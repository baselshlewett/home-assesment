<template>
    <div class="question">
        <h3>
            <span class="question_number">{{ questionNumber }}</span>
            <span class="question_text">{{ question.question_text }}</span>
        </h3>
        <div class="options_container">
            <div class="option" v-for="(option, index) in question.options" :key="index">
                <QuizOption 
                    :option="option"
                    :index="index"
                    :selectedAnswer="getSelectedAnswer()"
                    :questionNumber="questionNumber"
                    :isReadOnly="isReadOnly"
                    :userAnswer="userAnswer"
                    @update:selectedAnswer="(answer_id) => updateSelectedAnswer(question.id, answer_id)"
                ></QuizOption>
            </div>
        </div>
    </div>
</template>

<script>
import QuizOption from '@/components/screens/features/quiz/option/QuizOption.vue'

export default {
    name: 'QuizQuestionsScreen',
    components: { QuizOption },
    props: {
        question: {
            type: Object,
            required: true
        },
        questionNumber: {
            type: Number,
            required: true
        },
        selectedAnswer: {
            type: Number,
            required: false
        },
        isReadOnly: {
            type: Boolean,
            required: false
        },
        userAnswer: {
            type: Number,
            required: false
        }
    },
    data() {
        return {}
    },
    methods: {
        updateSelectedAnswer(question_id, answer_id) {
            this.$emit('update:selectedAnswer', {
                question_id,
                answer_id
            })
        },
        getSelectedAnswer() {
            if (this.isReadOnly) {
                return this.userAnswer;
            }
            return this.selectedAnswer;
        }
    }
}
</script>

<style lang="scss" scoped>
@import '@/utilities/css/vars/vars.scss';
.question {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: 50%;
    gap: 20px;
    padding-bottom: 20px;

    h3 {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        gap: 15px;

        .question_number {
            font-size: 40px;
            font-family: $FONT_BOLD;
        }

        .question_text {
            padding-top: 5px;
            font-size: $FONT_SIZE_M;
            font-family: $FONT_REGULAR;
        }
    }
}
.options_container {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
}
</style>