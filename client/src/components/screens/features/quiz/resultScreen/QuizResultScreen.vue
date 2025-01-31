<template>
    <div class="quiz_summary_container">
        <Navigator
            :items="[
            { text: quiz.name, to: '/feature/quiz' },
            { text: 'Quiz', to: '' }
            ]"
        />
        <div class="quiz_summary_questions_container">
            <div class="quiz_summary_header">
                <h3>Scored {{ `${data.correct_answers_count}/${data.total_questions}` }}</h3>
            </div>
            <div v-for="(answer, index) in data.answers" :key="index" class="question_container">
                <Question
                :question="answer.question"
                :questionNumber="index + 1"
                :selectedAnswer="answer.answer_id"
                :userAnswer="answer.answer_id"
                :isReadOnly="true"
                />
            </div>
        </div>
        <BaseButton :theme="BUTTON_THEMES.SECONDARY" @click="resetQuiz()">Go Home</BaseButton>
    </div>
</template>
<script>

import { useQuizStore } from '@/stores/quiz'
import Question from '@/components/screens/features/quiz/question/Question.vue'
import BaseButton from '@/components/base/button/BaseButton.vue'
import { THEMES as BUTTON_THEMES } from '@/components/base/button/config.js'
import Navigator from '@/components/compositions/navigator/Navigator.vue'

export default {
    name: 'QuizResultScreen',
    components: { Question, BaseButton, Navigator },
    props: {
        quiz: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            BUTTON_THEMES,
            data: {
                total_questions: 0,
                correct_answers_count: 0,
                answers: {
                },
            },
        }
    },
    mounted() {
        const store = useQuizStore()
        store.getQuizSummaryById(1, (status) => {
            if (status) {
                this.data = store.quizSummary
            } else {
                alert('Error fetching quiz summary')
            }
        });
    },
    methods: {
        resetQuiz() {
            const store = useQuizStore()
            store.resetSelectedAnswers()
            this.$emit('resetQuiz')
        }
    }
}
</script>

<style lang="scss" scoped>
    @import '@/utilities/css/vars/vars.scss';

    .quiz_summary_container {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 100px;
        box-sizing: border-box;
        width: 100%;
        gap: 1.2rem;
        padding-bottom: 20px;
        background-color: $SNOW;
    }

    .quiz_summary_questions_container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        width: 100%;
        background: $WHITE;
    }

    .question_container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.2rem;
        width: 100%;

        &:not(:last-child) {
            border-bottom: $BORDER_THIN
        }
    }

    .quiz_summary_header {
        display: flex;
        justify-content: center;
        width: 100%;
        background: $LIGHT_BLUE6;
        padding: 20px;
        border-top: $BORDER_THIN;
        border-color: $URBAN_MIST;

        h3 {
            font-size: $FONT_SIZE_XL;
            font-family: $FONT_BOLD;
        }
    }
</style>
