<template>
  <div class="quiz_container">
    <div v-if="data">
      <QuizStartScreen v-if="quizState === QUIZ_STATES.START" :name="data.name" :questionsLength="data.questions.length" @start="start"></QuizStartScreen>
      <QuizQuestionsScreen v-if="quizState === QUIZ_STATES.QUESTIONS" :quiz="data" @completed="completed()"></QuizQuestionsScreen>
      <QuizResultScreen v-if="quizState === QUIZ_STATES.RESULT" :quiz="data" @resetQuiz="reset()"></QuizResultScreen>
    </div>
    <div v-else>Loading...</div>
  </div>
</template>

<script>
import QuizStartScreen from './startScreen/QuizStartScreen.vue'
import QuizQuestionsScreen from './questionsScreen/QuizQuestionsScreen.vue'
import QuizResultScreen from './resultScreen/QuizResultScreen.vue'
const QUIZ_STATES = {
  START: 'start',
  QUESTIONS: 'questions',
  RESULT: 'result'
}

export default {
  name: 'Quiz',
  components: {
    QuizStartScreen,
    QuizQuestionsScreen,
    QuizResultScreen
  },
  props: {
    data: {
      type: Object,
      required: false
    }
  },
  data() {
    return {
      QUIZ_STATES,
      quizState: QUIZ_STATES.START
    }
  },
  methods: {
    start() {
      this.quizState = QUIZ_STATES.QUESTIONS
    },
    completed() {
      this.quizState = QUIZ_STATES.RESULT
    },
    reset() {
      this.quizState = QUIZ_STATES.START
    }
  }
}
</script>

<style lang="scss" scoped>
.quiz_container {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;

  > div {
    width: 100%;
  }
}
</style>
