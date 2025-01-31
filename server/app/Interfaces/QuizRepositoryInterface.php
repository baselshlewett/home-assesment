<?php

namespace App\Interfaces;

interface QuizRepositoryInterface
{
    public function getQuiz($id);
    public function storeUserAnswers($quizId, $userId, $answers);
    public function getUserAnswersData($quizId);
}
