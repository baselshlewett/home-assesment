<template>
  <div class="feature_container">
    <component v-if="supportedFeatures[featureType]" :data="data" :is="featureType" />
    <span v-else>{{ featureType }} feature is NOT supported YET</span>
  </div>
</template>

<script>
// FEATURE TYPES
import Quiz from '@/components/screens/features/quiz/Quiz.vue'

//FEATURE STORES
import { useQuizStore } from '@/stores/quiz'

export default {
  name: 'Feature',
  components: {
    Quiz
  },
  data() {
    return {
      supportedFeatures: {
        quiz: true
      },
      featureType: 'quiz',
      data: null
    }
  },
  methods: {
  },
  mounted() {
    this.featureType = this.$route.params.type?.toLowerCase() || this.featureType.toLowerCase()

    if (this.featureType === 'quiz') {
      const store = useQuizStore()
      store.getQuizById(1, () => {
        this.data = {
          name: store.quiz.title,
          questions: (store.quiz.questions)
        }
      });
    }
  }
}
</script>

<style lang="scss" scoped>
.feature_container {
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
