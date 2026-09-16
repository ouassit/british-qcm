<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Choice;
use App\Models\Question;
use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestImportController extends Controller
{
    public function index()
    {
        $this->ensureSuperAdmin();

        $centers = User::where(function ($query) {
                $query->where('super_admin', false)->orWhereNull('super_admin');
            })
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'username']);

        return view('test-import.index', compact('centers'));
    }

    public function sourceTests(User $center)
    {
        $this->ensureCenter($center);

        return response()->json(
            Test::where('user_id', $center->id)
                ->withCount('questions')
                ->orderBy('name')
                ->get(['id', 'name', 'duration'])
        );
    }

    public function import(Request $request)
    {
        $this->ensureSuperAdmin();

        $data = $request->validate([
            'source_center_id' => 'required|integer|different:destination_center_id|exists:users,id',
            'destination_center_id' => 'required|integer|exists:users,id',
            'test_id' => 'required|integer|exists:tests,id',
        ]);

        $source = User::findOrFail($data['source_center_id']);
        $destination = User::findOrFail($data['destination_center_id']);
        $this->ensureCenter($source);
        $this->ensureCenter($destination);

        $test = Test::where('id', $data['test_id'])
            ->where('user_id', $source->id)
            ->with('questions.choices', 'questions.categorie')
            ->firstOrFail();

        $result = DB::transaction(function () use ($test, $destination) {
            $newTest = $test->replicate();
            $newTest->user_id = $destination->id;
            $newTest->save();

            $categories = Categorie::where('user_id', $destination->id)
                ->get()
                ->keyBy(function ($category) {
                    return mb_strtolower(trim($category->name));
                });
            $categoryMap = [];
            $questionsCount = 0;
            $choicesCount = 0;

            foreach ($test->questions as $question) {
                $newQuestion = $question->replicate();
                $newQuestion->test_id = $newTest->id;
                $newQuestion->user_id = $destination->id;
                $newQuestion->categorie_id = $this->destinationCategoryId($question, $destination, $categories, $categoryMap);
                $newQuestion->save();
                $questionsCount++;

                foreach ($question->choices as $choice) {
                    $newChoice = $choice->replicate();
                    $newChoice->question_id = $newQuestion->id;
                    $newChoice->save();
                    $choicesCount++;
                }
            }

            return compact('newTest', 'questionsCount', 'choicesCount');
        });

        return response()->json([
            'success' => true,
            'test' => $result['newTest']->name,
            'questions' => $result['questionsCount'],
            'choices' => $result['choicesCount'],
        ]);
    }

    private function destinationCategoryId(Question $question, User $destination, $categories, array &$categoryMap)
    {
        if (!$question->categorie) {
            return null;
        }

        $key = mb_strtolower(trim($question->categorie->name));
        if (isset($categoryMap[$key])) {
            return $categoryMap[$key];
        }

        if ($categories->has($key)) {
            return $categoryMap[$key] = $categories->get($key)->id;
        }

        $category = Categorie::create([
            'name' => $question->categorie->name,
            'user_id' => $destination->id,
        ]);
        $categories->put($key, $category);

        return $categoryMap[$key] = $category->id;
    }

    private function ensureSuperAdmin()
    {
        abort_unless(auth()->user() && auth()->user()->super_admin, 403);
    }

    private function ensureCenter(User $center)
    {
        $this->ensureSuperAdmin();
        abort_if($center->super_admin, 403);
    }
}
