<?php

namespace App\Support;

use App\Models\Categorie;
use App\Models\Choice;
use App\Models\Question;
use App\Models\Test;
use App\Models\User;

class DemoAccountSeeder
{
    public static function seed(User $user): void
    {
        $categories = [
            'Grammar' => Categorie::create([
                'name' => 'Grammar',
                'user_id' => $user->id,
            ]),
            'Listening' => Categorie::create([
                'name' => 'Listening',
                'user_id' => $user->id,
            ]),
        ];

        $test = Test::create([
            'name' => 'Demo Placement Test',
            'duration' => 1800,
            'user_id' => $user->id,
        ]);

        $questions = [
            [
                'category' => 'Grammar',
                'question' => 'Choose the correct sentence.',
                'choices' => [
                    ['answer' => 'She go to school every day.', 'correct' => 0],
                    ['answer' => 'She goes to school every day.', 'correct' => 1],
                    ['answer' => 'She going to school every day.', 'correct' => 0],
                ],
            ],
            [
                'category' => 'Grammar',
                'question' => 'Complete the sentence: I have lived here _____ 2020.',
                'choices' => [
                    ['answer' => 'for', 'correct' => 0],
                    ['answer' => 'since', 'correct' => 1],
                    ['answer' => 'during', 'correct' => 0],
                ],
            ],
            [
                'category' => 'Listening',
                'question' => 'Listening task: The speaker says the meeting starts at 9:30. What time is the meeting?',
                'choices' => [
                    ['answer' => '9:00', 'correct' => 0],
                    ['answer' => '9:30', 'correct' => 1],
                    ['answer' => '10:30', 'correct' => 0],
                ],
            ],
            [
                'category' => 'Listening',
                'question' => 'Listening task: The customer asks for a return ticket. What does the customer need?',
                'choices' => [
                    ['answer' => 'A one-way ticket', 'correct' => 0],
                    ['answer' => 'A return ticket', 'correct' => 1],
                    ['answer' => 'A monthly pass', 'correct' => 0],
                ],
            ],
        ];

        foreach ($questions as $index => $item) {
            $question = Question::create([
                'question' => $item['question'],
                'test_id' => $test->id,
                'categorie_id' => $categories[$item['category']]->id,
                'user_id' => $user->id,
                'ordre' => $index + 1,
            ]);

            foreach ($item['choices'] as $choice) {
                Choice::create([
                    'answer' => $choice['answer'],
                    'correct' => $choice['correct'],
                    'question_id' => $question->id,
                ]);
            }
        }
    }
}
