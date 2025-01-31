<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAnswerRequest;
use App\Models\Quiz;
use App\Repositories\QuizRepository;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Handles a request for fetching quiz by it's ID and it's questions
     *
     * Sample Success Response (200):
     * {
     *      'id': 1,
     *      'name': 'Quiz 1',
     *      'questions': [
     *          {
     *              'id': 1,
     *              'question_text': 'Question 1',
     *              'options': [
     *                  {
     *                      'id': 1,
     *                      'option_text': 'Option 1',
     *                      'is_correct': true
     *                  },
     *          }
     *      ]
     * }
     * Sample Failed Response (404):
     * {
     *    'message': 'Quiz not found'
     * }
     *
     * @param
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, QuizRepository $quizRepository)
    {
        $quizData = $quizRepository->getQuiz($request->id);

        return response()->json($quizData);
    }

    /**
     * Handles a Quiz Answer store request
     *
     * Sample Request Payload:
     * [
     *    {
     *     'question_id': 1,
     *     'answer_id': 1
     *   },
     *   {
     *     'question_id': 1,
     *     'answer_id': 1
     *   },
     * ]
     * Sample Success Response (200):
     * {
     *     'message': 'Answers stored successfully'
     * }
     * Sample Failed Response (500):
     * {
     *    'message': 'Failed to store answers',
     * }
     *
     * @param
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserAnswerRequest $userAnswerRequest, QuizRepository $quizRepository)
    {
        $userAnswersData = $userAnswerRequest->validated();
        $userId = auth('sanctum')->id();
        $quizId = $userAnswerRequest->id;

        try {
            $quizRepository->storeUserAnswers($quizId, $userId, $userAnswersData);

            return response()->json(
                [
                    'message' => 'Answers stored successfully',
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Failed to store answers',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    /**
     * Handles a request for fetching quiz user answers by quiz id
     *
     * Sample Success Response (200):
     * {
     *     'answers': [
     *         {
     *             'id': 1,
     *             'question_id': 1,
     *             'answer_id': 1,
     *             'user_id': 1,
     *             'questions': {
     *                 'id': 1,
     *                 'question_text': 'Question 1',
     *                 'options': [
     *                     {
     *                         'id': 1,
     *                         'option_text': 'Option 1',
     *                         'is_correct': true
     *                     },
     *                 ]
     *             }
     *         }
     *     ],
     *     'correct_answers_count': 1,
     *     'total_questions': 1
     * }
     * Sample Failed Response (401):
     * {
     *     'message': 'Invalid answer details'
     * }
     *
     * @param
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuizSummary(Request $request, QuizRepository $quizRepository)
    {
        $quizId = $request->id;

        // Check if the quiz exists
        if (!Quiz::where('id', $quizId)->exists()) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $userAnswersData = $quizRepository->getUserAnswersData($quizId);

        return response()->json($userAnswersData);
    }
}
