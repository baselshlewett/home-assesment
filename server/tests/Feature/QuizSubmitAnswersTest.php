<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class QuizSubmitAnswersTest extends TestCase
{
    use DatabaseTransactions;

    public function test_submit_answers()
    {
        $token = $this->authenticateUser();

        $response = $this->post('/api/quiz/1', [
            [
                'question_id' => 1,
                'answer_id' => 1
            ],
            [
                'question_id' => 2,
                'answer_id' => 2
            ],
            [
                'question_id' => 3,
                'answer_id' => 3
            ],
            [
                'question_id' => 4,
                'answer_id' => 4
            ],
            [
                'question_id' => 5,
                'answer_id' => 5
            ]
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'message'
        ]);

        $response->assertJson([
            'message' => 'Answers stored successfully'
        ]);
    }

    public function test_submit_answers_with_invalid_question_id()
    {
        $token = $this->authenticateUser();

        $response = $this->post('/api/quiz/1', [
            'answers' => [
                [
                    'question_id' => 0,
                    'answer_id' => 1
                ]
            ]
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(422);
    }

    public function test_submit_answers_with_invalid_answer_id()
    {
        $token = $this->authenticateUser();

        $response = $this->post('/api/quiz/1', [
            'answers' => [
                [
                    'question_id' => 1,
                    'answer_id' => 0
                ]
            ]
        ], [
                'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(422);
    }

    public function test_submit_answers_with_invalid_quiz_id()
    {
        $token = $this->authenticateUser();

        $response = $this->post('/api/quiz/0', [
            'answers' => [
                [
                    'question_id' => 1,
                    'answer_id' => 1
                ]
            ]
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(422);
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
