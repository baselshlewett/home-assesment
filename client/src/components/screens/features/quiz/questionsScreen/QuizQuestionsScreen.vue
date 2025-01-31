<template>
  <div class="quiz_questions_container">
    <Navigator
      :items="[
        { text: quiz.name, to: '/feature/quiz' },
        { text: 'Quiz', to: '' }
      ]"
    />
    <main class="quiz_questions_content">
      <div class="questions_container">
        <div v-for="(question, index) in quiz.questions" :key="index" class="question_container">
          <Question v-if="isQuestionActive(index)"
            :question="question"
            :questionNumber="index + 1"
            @update:selectedAnswer="(answerData) => updateSelectedAnswer(answerData.question_id, answerData.answer_id)"
            :selectedAnswer="quizStore.getSelectedAnswerByQuestionId(question.id)"
            />
        </div>
      </div>
      
      <div class="quiz_questions_footer">
        <BaseButton v-if="hasPreviousQuestion()" @click="previousQuestion()" :theme="BUTTON_THEMES.OUTLINE">Back</BaseButton>
        <BaseButton v-if="!isLastQuestion()" :disabled="isNextDisabled()" @click="nextQuestion()" :theme="BUTTON_THEMES.PRIMARY">Next</BaseButton>
        <BaseButton v-if="isLastQuestion()" :disabled="isSubmitDisabled()" :theme="BUTTON_THEMES.PRIMARY" @click="submit">Submit</BaseButton>
      </div>
    </main>
  </div>
</template>

<script>
import { THEMES as BUTTON_THEMES } from '@/components/base/button/config.js'
import BaseButton from '@/components/base/button/BaseButton.vue'
import Question from '../question/Question.vue'

// COMPOSITIONS
import Navigator from '@/components/compositions/navigator/Navigator.vue'
import { useQuizStore } from '@/stores/quiz'

export default {
  name: 'QuizQuestionsScreen',
  components: { BaseButton, Navigator, Question },
  props: {
    quiz: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      BUTTON_THEMES,
      currentQuestionIndex: 0,
      quizStore: useQuizStore(),
      showSummary: false
    }
  },
  methods: {
    nextQuestion() {
      if (!this.isLastQuestion()) {
        this.currentQuestionIndex++
      }
    },
    previousQuestion() {
      if (this.hasPreviousQuestion()) {
        this.currentQuestionIndex--
      }
    },
    isLastQuestion() {
      return this.currentQuestionIndex === this.quiz.questions.length - 1
    },
    hasPreviousQuestion() {
      return this.currentQuestionIndex > 0
    },
    isQuestionActive(index) {
      return index === this.currentQuestionIndex
    },
    updateSelectedAnswer(question_id, answer_id) {
      this.quizStore.updateAnswer(question_id, answer_id)
    },
    isNextDisabled() {
      return this.quizStore.getSelectedAnswerByQuestionId(this.quiz.questions[this.currentQuestionIndex].id) === null
    },
    isSubmitDisabled() {
      return this.quizStore.getSelectedAnswers.length !== this.quiz.questions.length
    },
    submit() {
      this.quizStore.submitQuiz((submitStatus) => {
        if (submitStatus) {
          this.$emit('completed')
        } else {
          alert('Failed to submit quiz')
        }
      })
    },
  }
}
</script>

<style lang="scss" scoped>
  @import '@/utilities/css/vars/vars.scss';

  h3 {
    span {
      margin-left: 10px;
    }
  }

.quiz_questions_container {
  padding-top: 100px;
  box-sizing: border-box;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: $SNOW;
}

.quiz_questions_content {
  padding-top: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  height: 100%;
  gap: 1.2rem;
  background: $WHITE;
  box-sizing: border-box;
  border-top: $BORDER_THIN;
  border-color: $URBAN_MIST;
}

.questions_container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.2rem;
  width: 100%;
  height: 100%;
}

.question_container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.2rem;
  width: 100%;

  &:empty {
    display: none;
  }
}

.quiz_questions_footer {
  display: flex;
  justify-content: flex-end;
  gap: 1.2rem;
  border-top: $BORDER_THIN;
  width: 100%;
  padding: 20px;
  box-sizing: border-box;
}
</style>
