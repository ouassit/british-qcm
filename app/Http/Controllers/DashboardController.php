<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Question;
use App\Models\StudentTest;
use App\Models\Test;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->super_admin) {
            return $this->superAdminDashboard();
        }

        $testIds = Test::where('user_id', $user->id)->pluck('id');

        $totalTests = $testIds->count();
        $totalCategories = Categorie::where('user_id', $user->id)->count();
        $totalQuestions = Question::where('user_id', $user->id)->count();

        $studentTestsQuery = StudentTest::whereIn('test_id', $testIds);
        $totalStudentTests = (clone $studentTestsQuery)->count();
        $finishedTests = (clone $studentTestsQuery)->where('expired', 1)->count();
        $inProgressTests = (clone $studentTestsQuery)
            ->where(function ($query) {
                $query->where('expired', 0)->orWhereNull('expired');
            })
            ->where('consumed_time', '>', 0)
            ->count();
        $notStartedTests = max($totalStudentTests - $finishedTests - $inProgressTests, 0);
        $todayTests = (clone $studentTestsQuery)->whereDate('date', Carbon::today())->count();

        $scoreRows = DB::table('student_tests')
            ->selectRaw('student_tests.id, tests.name as test_name, tests.duration')
            ->selectRaw('(SELECT COUNT(*) FROM questions WHERE questions.test_id = student_tests.test_id) as total_questions')
            ->selectRaw('(SELECT COUNT(*) FROM answers JOIN choices ON choices.id = answers.choice_id WHERE answers.student_test_id = student_tests.id AND choices.correct = 1) as correct_answers')
            ->join('tests', 'student_tests.test_id', '=', 'tests.id')
            ->where('tests.user_id', $user->id)
            ->where('student_tests.expired', 1)
            ->get();

        $averageScore = $scoreRows->count() > 0
            ? round($scoreRows->avg(function ($row) {
                return $row->total_questions > 0 ? ($row->correct_answers / $row->total_questions) * 100 : 0;
            }))
            : 0;

        $completionRate = $totalStudentTests > 0 ? round(($finishedTests / $totalStudentTests) * 100) : 0;

        $testsPerformance = Test::where('user_id', $user->id)
            ->withCount('questions')
            ->orderBy('name')
            ->get()
            ->map(function ($test) {
                $studentTests = StudentTest::where('test_id', $test->id);
                $total = (clone $studentTests)->count();
                $finished = (clone $studentTests)->where('expired', 1)->count();

                $scores = DB::table('student_tests')
                    ->selectRaw('student_tests.id')
                    ->selectRaw('(SELECT COUNT(*) FROM questions WHERE questions.test_id = student_tests.test_id) as total_questions')
                    ->selectRaw('(SELECT COUNT(*) FROM answers JOIN choices ON choices.id = answers.choice_id WHERE answers.student_test_id = student_tests.id AND choices.correct = 1) as correct_answers')
                    ->where('student_tests.test_id', $test->id)
                    ->where('student_tests.expired', 1)
                    ->get();

                return [
                    'name' => $test->name,
                    'questions' => $test->questions_count,
                    'assigned' => $total,
                    'finished' => $finished,
                    'average' => $scores->count() > 0
                        ? round($scores->avg(function ($row) {
                            return $row->total_questions > 0 ? ($row->correct_answers / $row->total_questions) * 100 : 0;
                        }))
                        : 0,
                ];
            });

        $recentStudentTests = StudentTest::with('test')
            ->whereIn('test_id', $testIds)
            ->orderBy('date', 'desc')
            ->limit(6)
            ->get();

        $daysLeft = null;
        if (!empty($user->expire_date)) {
            $daysLeft = Carbon::now()->diffInDays(Carbon::parse($user->expire_date), false);
        }
        $expirationNotice = $this->expirationNotice($user);

        return view('dashboard', compact(
            'totalTests',
            'totalCategories',
            'totalQuestions',
            'totalStudentTests',
            'finishedTests',
            'inProgressTests',
            'notStartedTests',
            'todayTests',
            'averageScore',
            'completionRate',
            'testsPerformance',
            'recentStudentTests',
            'daysLeft',
            'expirationNotice'
        ));
    }

    public function renewCenter(Request $request, User $center)
    {
        if (!auth()->user()->super_admin || $center->super_admin) {
            abort(403);
        }

        $data = $request->validate([
            'months' => 'nullable|integer|min:1|max:36',
            'expire_date' => 'nullable|date',
        ]);

        if (!empty($data['expire_date'])) {
            $expireDate = Carbon::parse($data['expire_date']);
        } else {
            $months = $data['months'] ?? 1;
            $baseDate = !empty($center->expire_date) && Carbon::parse($center->expire_date)->isFuture()
                ? Carbon::parse($center->expire_date)
                : Carbon::today();
            $expireDate = $baseDate->copy()->addMonths($months);
        }

        $center->expire_date = $expireDate->format('Y-m-d');
        $center->save();

        $daysLeft = Carbon::today()->diffInDays($expireDate, false);

        return response()->json([
            'success' => true,
            'expire_date' => $expireDate->format('Y-m-d'),
            'days_left' => $daysLeft,
            'status_label' => $this->expirationLabel($daysLeft),
            'status_class' => $this->expirationClass($daysLeft),
        ]);
    }

    public function updateCenterPassword(Request $request, User $center)
    {
        if (!auth()->user()->super_admin || $center->super_admin) {
            abort(403);
        }

        $data = $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $center->password = Hash::make($data['password']);
        $center->save();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.',
        ]);
    }

    private function superAdminDashboard()
    {
        $lastMonthStart = Carbon::today()->subDays(30);

        $centers = User::where(function ($query) {
                $query->where('super_admin', false)->orWhereNull('super_admin');
            })
            ->orderBy('name')
            ->get()
            ->map(function ($center) use ($lastMonthStart) {
                $testIds = Test::where('user_id', $center->id)->pluck('id');
                $studentTestsQuery = StudentTest::whereIn('test_id', $testIds);
                $totalStudentTests = (clone $studentTestsQuery)->count();
                $lastMonthStudentTests = (clone $studentTestsQuery)->whereDate('date', '>=', $lastMonthStart)->count();
                $finishedTests = (clone $studentTestsQuery)->where('expired', 1)->count();
                $inProgressTests = (clone $studentTestsQuery)
                    ->where(function ($query) {
                        $query->where('expired', 0)->orWhereNull('expired');
                    })
                    ->where('consumed_time', '>', 0)
                    ->count();

                $scoreRows = DB::table('student_tests')
                    ->selectRaw('student_tests.id')
                    ->selectRaw('(SELECT COUNT(*) FROM questions WHERE questions.test_id = student_tests.test_id) as total_questions')
                    ->selectRaw('(SELECT COUNT(*) FROM answers JOIN choices ON choices.id = answers.choice_id WHERE answers.student_test_id = student_tests.id AND choices.correct = 1) as correct_answers')
                    ->whereIn('student_tests.test_id', $testIds)
                    ->where('student_tests.expired', 1)
                    ->get();

                $averageScore = $scoreRows->count() > 0
                    ? round($scoreRows->avg(function ($row) {
                        return $row->total_questions > 0 ? ($row->correct_answers / $row->total_questions) * 100 : 0;
                    }))
                    : 0;

                $daysLeft = null;
                if (!empty($center->expire_date)) {
                    $daysLeft = Carbon::today()->diffInDays(Carbon::parse($center->expire_date), false);
                }

                return [
                    'id' => $center->id,
                    'name' => $center->name,
                    'email' => $center->email,
                    'username' => $center->username,
                    'expire_date' => $center->expire_date ? Carbon::parse($center->expire_date)->format('Y-m-d') : null,
                    'days_left' => $daysLeft,
                    'expiration_label' => is_null($daysLeft) ? 'No date' : $this->expirationLabel($daysLeft),
                    'expiration_class' => is_null($daysLeft) ? 'badge-waiting' : $this->expirationClass($daysLeft),
                    'export_test' => (bool) $center->export_test,
                    'tests' => $testIds->count(),
                    'categories' => Categorie::where('user_id', $center->id)->count(),
                    'questions' => Question::where('user_id', $center->id)->count(),
                    'assigned' => $totalStudentTests,
                    'last_month_assigned' => $lastMonthStudentTests,
                    'finished' => $finishedTests,
                    'in_progress' => $inProgressTests,
                    'average_score' => $averageScore,
                ];
            });

        $totalCenters = $centers->count();
        $activeCenters = $centers->filter(function ($center) {
            return !is_null($center['days_left']) && $center['days_left'] >= 0;
        })->count();
        $expiringCenters = $centers->filter(function ($center) {
            return !is_null($center['days_left']) && $center['days_left'] >= 0 && $center['days_left'] <= 15;
        })->count();
        $expiredCenters = $centers->filter(function ($center) {
            return !is_null($center['days_left']) && $center['days_left'] < 0;
        })->count();
        $lastMonthStudentTests = $centers->sum('last_month_assigned');

        return view('dashboard-super-admin', compact(
            'centers',
            'totalCenters',
            'activeCenters',
            'expiringCenters',
            'expiredCenters',
            'lastMonthStudentTests'
        ));
    }

    private function expirationLabel($daysLeft)
    {
        if ($daysLeft < 0) {
            return 'Expired';
        }

        if ($daysLeft <= 15) {
            return 'Expiring soon';
        }

        return 'Active';
    }

    private function expirationClass($daysLeft)
    {
        if ($daysLeft < 0) {
            return 'badge-expired';
        }

        if ($daysLeft <= 15) {
            return 'badge-progress';
        }

        return 'badge-finished';
    }

    private function expirationNotice(User $user)
    {
        if (empty($user->expire_date)) {
            return [
                'show' => false,
                'message' => '',
            ];
        }

        $expireDate = Carbon::parse($user->expire_date);
        $daysLeft = Carbon::now()->diffInDays($expireDate, false);

        if ($daysLeft <= 15 && $daysLeft >= 0) {
            return [
                'show' => true,
                'message' => "Your subscription will expire in <b>".$daysLeft." days (".$expireDate->format('d/m/Y').")</b>.<br><br>Please renew to avoid service interruption.<br><br>
                    <div class='payment-details'>
                    Send Payment to:<br><br>
                    Bank: CIH<br>
                    RIB: 230 787 4079049211003800 97<br>
                    Send proof of payment to: 0662584945<br></div>",
            ];
        }

        if ($daysLeft < 0) {
            return [
                'show' => true,
                'message' => "Your subscription expired on <b>".$expireDate->format('d/m/Y')."</b>.<br><br>Please renew soon to avoid service interruption.<br><br>
                    <div class='payment-details'>
                    Send Payment to:<br><br>
                    Bank: CIH<br>
                    RIB: 230 787 4079049211003800 97<br>
                    Send proof of payment to: 0662584945<br></div>",
            ];
        }

        return [
            'show' => false,
            'message' => '',
        ];
    }
}
