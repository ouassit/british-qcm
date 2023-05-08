<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class StudentTest extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    protected $appends = ['result', 'answers'];

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function getResultAttribute(){
        return DB::table('answers')
        ->selectRaw('count(*) as result')
        ->join('questions', 'question_id', '=', 'questions.id')
        ->join('choices', 'choice_id', '=', 'choices.id')
        ->where('student_test_id', $this->id)
        ->where('correct', '1')
        ->get()[0]->result;
    }

    public function getAnswersAttribute() {
        return DB::select('SELECT questions.question as question,
                (SELECT answer FROM choices WHERE choices.question_id = questions.id AND correct=1) AS correct_choice,
                (SELECT answer FROM answers JOIN choices ON choices.id=answers.choice_id WHERE answers.question_id = questions.id and student_test_id='.$this->id .') AS selected_choice,
                (SELECT correct FROM answers JOIN choices ON choices.id=answers.choice_id WHERE answers.question_id = questions.id and student_test_id='.$this->id .') AS correct
                from questions 
                WHERE questions.test_id = '.$this->test_id );
        
    }

}
