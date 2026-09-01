<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Question;
use App\Models\Choice;
use App\Models\Test;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Controller as BaseController;


class NewCenterController extends BaseController
{


    
    public function copy()
    {

        /*$from_user_id = 19;
        $to_user_id = 22;

        $user = User::find($from_user_id);

        // Copier les catégories =========

        $categories = Categorie::where('user_id', $from_user_id)->orderBy('name')->get();
        $catsMap = array();

        foreach ($categories as $category) {
            $cat = Categorie::create([
                'name' => $category->name,
                'user_id' => $to_user_id
            ]);
            $cat->save(); 
            $catsMap[$category->id] = $cat->id;
        }

        // Copier les questions =========

        $tests = Test::where('user_id', $from_user_id)->with('questions.choices')->orderBy('name')->get();
        foreach ($tests as $test) {

            $newTest = $test->replicate();
            $newTest->user_id = $to_user_id;
            $newTest->save();

            // Cloner chaque question
            foreach ($test->questions as $question) {
                $newQuestion = $question->replicate();
                $newQuestion->categorie_id = $catsMap[$question->categorie_id];
                $newQuestion->test_id = $newTest->id;
                $newQuestion->user_id = $to_user_id;
                $newQuestion->save();

                // Cloner chaque choice de la question
                foreach ($question->choices as $choice) {
                    $newChoice = $choice->replicate();
                    $newChoice->question_id = $newQuestion->id;
                    $newChoice->save();
                }
            }

            
        }

        return response()->json('done copy');*/
    }

    public function create(){

        /*$user_id = 7;
        $test_id = 52;

        $json = file_get_contents(__DIR__ . '/adults.json');

        $categories = json_decode($json, true);

        foreach ($categories as $cat => $questions) {
            $new_cat = Categorie::create([
                'name' => $cat,
                'user_id' => $user_id
            ]);
            $new_cat->save();

            foreach ($questions as $q) {
                $new_question = Question::create([
                    'test_id' => $test_id,
                    'categorie_id' => $new_cat->id,
                    'user_id' => $user_id,
                    'question' => $q['question'],
                ]);
                $new_question->save();

                for($i=0; $i < sizeof($q['choices']); $i++) {
                    $correct = 0;
                    if($q['index']==$i){
                        $correct = 1;
                    }
                    $new_choice = Choice::create([
                        'answer' => $q['choices'][$i],
                        'correct' => $correct,
                        'question_id' => $new_question->id,
                    ]);
                    $new_choice->save();
                }

            }
        }*/

        return response()->json('done create');

    }

}
