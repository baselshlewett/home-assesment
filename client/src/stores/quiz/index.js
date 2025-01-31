import { getQuiz, updateQuizAnswers, getQuizSummary } from '@/utilities/api/quiz'
import { defineStore } from 'pinia'

export const useQuizStore = defineStore('quiz', {
    state: () => ({
        loaded: false,
        quiz: {
            name: '',
            questions: [],
            options: [],
        },
        selectedAnswers: [],
        quizSummary: {
            answers: [],
            correct_answers_count: 0,
            total_questions: 0,
        }
    }),
    getters: {
        getName: state => state.quiz.name,
        getQuestions: state => state.quiz.questions,
        getSelectedAnswers: state => state.selectedAnswers,
    },
    actions: {
        getQuizById(id, callback) {
            getQuiz(id).then(quiz => {
                this.quiz = quiz;
                this.loaded = true;
                callback(true);
            }).catch(error => {
                this.quiz = {
                    name: '',
                    questions: [],
                    options: [],
                };
                this.loaded = false;
                callback(false);
            });
        },
        updateAnswer(question_id, answer_id) {
            this.selectedAnswers = this.selectedAnswers.filter(selectedAnswer => selectedAnswer.question_id !== question_id);
            this.selectedAnswers.push({ question_id, answer_id });
        },
        getSelectedAnswerByQuestionId(question_id) {
            const answer = this.selectedAnswers.find(answer => answer.question_id === question_id);
            return answer ? answer.answer_id : null;
        },
        submitQuiz(callback) {
            updateQuizAnswers(this.quiz.id, this.getSelectedAnswers).then(response => {
                callback(true);
            }
            ).catch(error => {
                callback(false);
            });
        },
        resetSelectedAnswers() {
            this.selectedAnswers = [];
        },
        getQuizSummaryById(id, callback) {
            getQuizSummary(id).then(quizSummary => {
                this.quizSummary = quizSummary;
                callback(true);
            }).catch(error => {
                console.error(error);
                this.quizSummary = {
                    answers: [],
                    correct_answers_count: 0,
                    total_questions: 0,
                };
                callback(false);
            });
        }
    }
})
