<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class QuizGetUserAnswersTest extends TestCase
{
    public function test_get_user_answers()
    {
        $token = $this->authenticateUser();
        $response = $this->get('/api/quiz/1/summary', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'answers' => [
                '*' => [
                    'answer_id',
                    'id',
                    'quiz_id',
                    'question_id',
                    'answer_id',
                    'user_id',
                    'created_at',
                    'updated_at',
                    'question' => [
                        'id',
                        'quiz_id',
                        'question_text',
                        'created_at',
                        'updated_at',
                        'options' => [
                            '*' => [
                                'id',
                                'question_id',
                                'option_text',
                                'is_correct',
                                'created_at',
                                'updated_at',
                            ]
                        ]
                    ]
                ]
            ],
            'correct_answers_count',
            'total_questions',
        ]);
    }

    public function test_get_user_answers_not_found()
    {
        $token = $this->authenticateUser();
        $response = $this->get('/api/quiz/0/summary', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(404);
    }

    private function authenticateUser()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        return $response['access_token'];
    }
}
