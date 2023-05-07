<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Choice;
use App\Models\Question;
use App\Models\Test;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    private $question_rules = [
        'question' => 'required',
        'test_id' => 'required',
        'categorie_id' => 'required',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $questions = Question::where('user_id', $user->id);
        if($request->get('filter_test_id')!=''){
            $questions = $questions->where('test_id', $request->get('filter_test_id'));
        }
        $questions = $questions->orderBy('id')->paginate(200);
        $tests = Test::where('user_id', $user->id)->orderBy('name')->get();;
        $categories = Categorie::where('user_id', $user->id)->orderBy('name')->get();;
        return view('questions.index', compact('questions', 'categories', 'tests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        try {
            DB::transaction(function () use ($request) {
                
                $data = $request->validate($this->question_rules);
                $data = array_merge($data, ['user_id'=>auth()->user()->id]);

                $question = Question::create($data);

                if($request['answer']){
                    foreach($request['answer'] as $k => $p ) {
                        $data = [
                            'answer' => $request['answer'][$k],
                            'correct' => $request['correct'][$k],
                            'question_id' => $question->id,
                        ];
                        $item =  new Choice($data);
                        $item->save();
                    }
                }

            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 401);
        }
        return response()->json(['success' => true], 200);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::with('choices')->findOrFail($id);
        $user = auth()->user();
        if( $question->user_id != $user->id){
            return response()->json(['success' => false], 401);
        }
        return response()->json($question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {

                $data = $request->validate($this->question_rules);
                $data = array_merge($data, ['user_id'=>auth()->user()->id]);

                $question = Question::findOrFail($id);
                $question->update($data);

                $question->choices()->delete();
                if($request['answer']){
                    foreach($request['answer'] as $k => $p ) {
                        $data = [
                            'answer' => $request['answer'][$k],
                            'correct' => $request['correct'][$k],
                            'question_id' => $question->id,
                        ];
                        $item =  new Choice($data);
                        $item->save();
                    }
                }
                
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 401);
        }
        return response()->json(['success' => true], 200);
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
            $test = Question::findOrFail($id);
            $user = auth()->user();
            if( $test->user_id != $user->id){
                return response()->json(['success' => false], 401);
            }
            $test->delete();
        } catch (Exception $e) {
            return response()->json(['success' => false], 404);
        }
        return response()->json(['success' => true], 200);
    }
}
