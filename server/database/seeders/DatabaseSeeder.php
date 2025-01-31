<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (!\App\Models\User::where('email', 'basel@example.com')->exists()) {
            \App\Models\User::factory()->create([
            'name' => 'Basel Shlewett',
            'email' => 'basel@example.com',
            'password' => Hash::make('0542443785'),
            ]);
        }

        $quiz = \App\Models\Quiz::factory()->create([
            'title' => 'City Capitals Quiz',
        ]);

        $questions = [
            'What is the capital of France?' => 'Paris',
            'What is the capital of Germany?' => 'Berlin',
            'What is the capital of Spain?' => 'Madrid',
            'What is the capital of England?' => 'London',
            'What is the capital of Italy?' => 'Rome',
        ];

        foreach ($questions as $question => $correctOption) {
            $quizQuestion = \App\Models\QuizQuestion::factory()->create([
            'quiz_id' => $quiz->id,
            'question_text' => $question,
            ]);

            $options = ['Paris', 'London', 'Berlin', 'Madrid', 'Rome'];
            foreach ($options as $option) {
            \App\Models\QuestionOption::factory()->create([
                'question_id' => $quizQuestion->id,
                'option_text' => $option,
                'is_correct' => $option === $correctOption,
            ]);
            }
        }
    }
}
