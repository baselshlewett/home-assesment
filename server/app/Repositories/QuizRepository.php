<?php

namespace App\Repositories;

use App\Interfaces\QuizRepositoryInterface;
use App\Models\Quiz;
use App\Models\UserAnswer;

class QuizRepository implements QuizRepositoryInterface
{
    public function getQuiz($id)
    {
        return Quiz::with('questions.options')->findOrFail($id);
    }

    public function storeUserAnswers($quizId, $userId, $answers)
    {
        foreach ($answers as $answer) {
            UserAnswer::updateOrCreate(
                [
                    'quiz_id' => $quizId,
                    'question_id' => $answer['question_id'],
                    'user_id' => $userId
                ],
                [
                    'answer_id' => $answer['answer_id']
                ]
            );
        }
    }

    public function getUserAnswersData($quizId)
    {
        $userId = auth('sanctum')->id();
        // Get all user answers for the quiz with the questions and options
        $userAnswers = UserAnswer::where('quiz_id', $quizId)
            ->where('user_id', $userId)
            ->with('question.options')
            ->get();

        // Calculate the number of correct answers
        $correctAnswersCount = $userAnswers->filter(function ($userAnswer) {
            return $userAnswer->question->options->contains(function ($option) use ($userAnswer) {
                return $option->id === $userAnswer->answer_id && $option->is_correct;
            });
        })->count();

        return [
            'answers' => $userAnswers,
            'correct_answers_count' => $correctAnswersCount,
            'total_questions' => $userAnswers->count(),
        ];
    }
}
