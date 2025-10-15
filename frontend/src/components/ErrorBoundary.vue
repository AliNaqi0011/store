<template>
  <div class="error-boundary">
    <h2>Something went wrong</h2>
    <p>{{ error?.message || 'An unexpected error occurred' }}</p>
    <button @click="retry">Try Again</button>
  </div>
</template>

<script>
export default {
  name: 'ErrorBoundary',
  props: {
    error: {
      type: Error,
      default: null
    }
  },
  emits: ['retry'],
  methods: {
    retry() {
      this.$emit('retry')
    }
  }
}
</script>