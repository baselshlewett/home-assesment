<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class QuizGetQuizTest extends TestCase
{
    public function test_get_quiz()
    {
        $token = $this->authenticateUser();
        $response = $this->get('/api/quiz/1', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertJsonMissing(['questions.*.options.*.is_correct']);

        $response->assertJsonStructure([
            'id',
            'title',
            'created_at',
            'updated_at',
            'questions' => [
                '*' => [
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
                            'created_at',
                            'updated_at',
                        ]
                    ]
                ]
            ]
        ]);

        $response->assertStatus(200);
    }

    public function test_get_quiz_not_found()
    {
        $token = $this->authenticateUser();
        $response = $this->get('/api/quiz/0', [
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
