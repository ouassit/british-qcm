<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Categorie;
use App\Models\Choice;
use App\Models\StudentTest;
use App\Models\Test;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use PDF;

class StudentTestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tests = Test::where('user_id', auth()->user()->id)->get();

        $students_tests = StudentTest::whereHas('test', function($q){
            $q->where('user_id', auth()->user()->id);
        });
        if($request->get('filter_fullname')!=''){
            $students_tests = $students_tests->where(DB::raw("CONCAT(firstname,' ',lastname)"), 'like', '%'.$request->get('filter_fullname').'%');
        }
        $students_tests = $students_tests->orderBy('date', 'desc')->paginate(200);
        return view('students_tests.index', compact('students_tests', 'tests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('students_tests.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $student_test = StudentTest::findOrFail($id);
            $user = auth()->user();
            if( $student_test->test->user_id != $user->id){
                return response()->json(['success' => false, 'message'=>$user->id.' - '.$student_test->test->user_id], 401);
            }
            $student_test->delete();
            return response()->json(['success' => true], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message'=>$e], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
        ];

        try {
    
            $input = $request->all();
    
            $validator = Validator::make($input, $rules);
    
            if($validator->fails()){
                return response()->json($validator->errors(), 401);
            }
            
            if($request->has('birthday'))
                $input['birthday'] = Carbon::createFromTimestamp(strtotime($input['birthday']))->format('Y-m-d');
            
            $input['access_code'] = uniqid ('');

            $entity = StudentTest::create($input);

            return response()->json($entity, 200);

        } catch(Throwable $e){
            report($e);
            return response()->json($e->getMessage(), 401);      
        }
    }

    public function show(Request $request, $student_test_id)
    {
        try {
            
            $entity = StudentTest::with('test', 'test.user', 'test.questions', 'test.questions.categorie', 'test.questions.choices')->with(['test.questions.answer' => function ($q) use($student_test_id) {
                $q->where('student_test_id', $student_test_id);
            }])->find($student_test_id);
    
            if (is_null($entity)) {
                return response()->json('Entity not found.', 401); 
            }

            return response()->json(new JsonResource($entity), 200);

        } catch(Throwable $e){
            report($e);
            return response()->json($e->getMessage(), 401);    
        }
    }

    public function update(Request $request, $id)
    {

        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
        ];

        try {

            $entity = StudentTest::find($id);
    
            if (is_null($entity)) {
                return response()->json('Entity not found.', 401);    
            }

            $input = $request->all();
    
            $validator = Validator::make($input, $rules);
    
            if($validator->fails()){
                return response()->json($validator->errors(), 401);   
            }
            
            if($request->has('birthday'))
                $input['birthday'] = Carbon::createFromTimestamp(strtotime($input['birthday']))->format('Y-m-d');
            
            if($request->has('expired')){
                $input['expired'] = 1;
            } else {
                $input['expired'] = 0;
            }

            $entity->update($input);
            $entity->save();

            return response()->json(['success' => true], 200);

        } catch(Throwable $e){
            report($e);
            return response()->json($e->getMessage(), 401);      
        }
    }

    public function print(Request $request, $student_test_id, $correction) {
        try {

            $student_test = StudentTest::with('test.user')->find($student_test_id);
            
            if (is_null($student_test)) {
                return response()->json('Entity not found.', 401);    
            }
            

            $pdf = PDF::loadView('print.index', 
            ['student_test' => $student_test, 
            'correction' => $correction, 
            'logo' => public_path('images/logo-'.$student_test->test->user->id.'.png'),
            'true' => public_path('images/true.png'),
            'false' => public_path('images/false.png'),
            ]);
            return $pdf->stream('result.pdf');

        } catch(Throwable $e){
            report($e);
            return response()->json($e->getMessage(), 401);      
        }
        
    }


    /***
     * FOR API APP ===================================================================
     */


    public function apiStore(Request $request)
    {
        $rules = [
             'firstname' => 'required',
             'lastname' => 'required',
        ];
 
        try {
     
            $input = $request->all();
     
            $validator = Validator::make($input, $rules);
     
            if($validator->fails()){
                return response()->json($validator->errors(), 401);
            }
            
            if($request->has('birthday'))
                $input['birthday'] = Carbon::createFromTimestamp(strtotime($input['birthday']))->format('Y-m-d');
             
            $input['access_code'] = uniqid ('');
            $input['expired'] = 0;
 
            $entity = StudentTest::create($input);
 
            return response()->json($entity, 200);
 
        } catch(Throwable $e){
            return response()->json($e->getMessage(), 401);      
        }
    }

    public function apiShow(Request $request, $student_test_id)
    {
        try {
            
            $entity = StudentTest::with('test', 'test.user', 'test.questions', 'test.questions.categorie', 'test.questions.choices')->with(['test.questions.answer' => function ($q) use($student_test_id) {
                $q->where('student_test_id', $student_test_id);
            }])->find($student_test_id);
    
            if (is_null($entity)) {
                return response()->json('Entity not found.', 401); 
            }

            return response()->json(new JsonResource($entity), 200);

        } catch(Throwable $e){
            report($e);
            return response()->json($e->getMessage(), 401);    
        }
    }
    

    public function apiUpdate(Request $request, $id)
    {

        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
        ];

        try {

            $entity = StudentTest::find($id);
    
            if (is_null($entity)) {
                return response()->json('Entity not found.', 401);    
            }

            $input = $request->all();
    
            $validator = Validator::make($input, $rules);
    
            if($validator->fails()){
                return response()->json($validator->errors(), 401);   
            }
            
            if($input['birthday'])
                $input['birthday'] = Carbon::createFromTimestamp(strtotime($request->birthday))->format('Y-m-d');

            $entity->update($input);
            $entity->save();

            return response()->json($entity, 200);

        } catch(Throwable $e){
            report($e);
            return response()->json($e->getMessage(), 401);      
        }
    }

    public function findByAccessCode(Request $request, $access_code)
    {
        try {
            
            $entity = StudentTest::where('access_code', $access_code)->with('test.user')->first();
    
            if (is_null($entity)) {
                return response()->json('The access code was not recognized', 404);
            }

            if($entity->expired==1){
                return response()->json('The access code has been expired', 404);
            }

            return response()->json(new JsonResource($entity), 200);

        } catch(Throwable $e){
            report($e);
            return response()->json($e->getMessage(), 401);   
        }
    }

    public function answer(Request $request)
    {
        try {

            $request->except(['id']);
            
            $input = $request->all();

            $rules_answers = [
                'student_test_id'=>'required',
                'choice_id'=>'required',
                'question_id'=>'required',
                'consumed_time'=>'required',
            ];
    
            $validator = Validator::make($input, $rules_answers);
            if($validator->fails()){
                return response()->json($validator->errors(), 401);
            }
            
            $answer = Answer::where('student_test_id', $input['student_test_id'])
            ->where('question_id', $input['question_id'])->first();

            if(!is_null($answer)){
                $answer->update($input); 
            }else{
                Answer::create($input);
            }

            // Updated consumed time
            $student_test = StudentTest::find($input['student_test_id']);
            if(!is_null($student_test)){
                $student_test->consumed_time = $input['consumed_time'];
                $student_test->save(); 
            }

            return response()->json($input, 200);

        } catch(Throwable $e){
            report($e);
            return response()->json($e->getMessage(), 401);      
        }
    }

    public function finish(Request $request)
    {
        try {
            
            $input = $request->all();

            $rules_answers = [
                'answers'
            ];
    
            $validator = Validator::make($input, $rules_answers);
            if($validator->fails()){
                return response()->json($validator->errors(), 401);
            }

            $answers = json_decode($input['answers'], true);

            $count = 0;
            for ($i=0; $i < sizeof($answers); $i++) { 
                try{
                    if(!is_null($answers[$i])){
                        $entity = Answer::where('student_test_id', $answers[$i]['student_test_id'])
                        ->where('question_id', $answers[$i]['question_id'])->first();
                        unset($answers[$i]['id']);
                        if(!is_null($entity)){
                            $entity->update($answers[$i]); 
                        }else{
                            Answer::create($answers[$i]);
                        }
                        $stid = $answers[$i]['student_test_id']; 
                    }
                    $count++;
                } catch(Throwable $e){  
                    return response()->json($e->getMessage(), 401);  
                }
            }

            // Student test expire
            $student_test = StudentTest::with('test.user')->find($input['student_test_id']);
            if(!is_null($student_test)){
                $student_test->expired = 1;
                $student_test->save(); 
            }

            return response()->json($student_test, 200);

        } catch(Throwable $e){
            report($e);
            return response()->json($e->getMessage(), 401);      
        }
    }

    public function time(Request $request)
    {
        try {

            $input = $request->all();

            $rules_answers = [
                'student_test_id'=>'required',
                'consumed_time'=>'required',
            ];
    
            $validator = Validator::make($input, $rules_answers);
            if($validator->fails()){
                return response()->json($validator->errors(), 401);
            }
            
            // Updated consumed time
            $student_test = StudentTest::find($input['student_test_id']);
            if(!is_null($student_test)){
                $student_test->consumed_time = $input['consumed_time'];
                $student_test->save(); 
            }

            return response()->json($input, 200);

        } catch(Throwable $e){
            report($e);
            return response()->json($e->getMessage(), 401);      
        }
    }

    public function apiTests(Request $request, $user_id){
        return response()->json(Test::where('user_id', $user_id)->get(), 200);
    }

    public function apiCategories(Request $request, $user_id){
        return response()->json(Categorie::where('user_id', $user_id)->get(), 200);
    }
    
}
