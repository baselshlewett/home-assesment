import { get, post } from "../ApiWrapper";

/**
 * Fetches all quiz questions from the server.
 * 
 * @returns {Promise<Array>} returns an array of quiz object.
 * 
 */
export const getQuiz = (id) => {
    try {
        return get(`/api/quiz/${id}`);
    } catch (error) {
        console.error(error);
    }
};

/**
 * sends a request to the server to submit the answers to a question.
 * 
 * @returns {Promise<Array>} returns a response from the server.
 * 
 */
export const updateQuizAnswers = (quizId, selectedAnswers) => {
    try {
        return post(`/api/quiz/${quizId}`, selectedAnswers);
    } catch (error) {
        console.error(error);
    }
};

/**
 * sends a request to the server to fetch quiz summary.
 * 
 * @returns {Promise<Array>} returns a response from the server.
 * 
 */
export const getQuizSummary = (id) => {
    try {
        return get(`/api/quiz/${id}/summary`);
    } catch (error) {
        console.error(error);
    }
}