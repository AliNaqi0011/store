<template>
  <div class="flex items-center justify-center" :class="containerClass">
    <div class="relative">
      <div class="animate-spin rounded-full border-4 border-gray-200" 
           :class="spinnerClass"
           :style="`border-top-color: ${color}; width: ${size}; height: ${size}`">
      </div>
      <div v-if="text" class="mt-4 text-center">
        <p class="text-gray-600 font-medium">{{ text }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'LoadingSpinner',
  props: {
    size: {
      type: String,
      default: '40px'
    },
    color: {
      type: String,
      default: '#3b82f6'
    },
    text: {
      type: String,
      default: ''
    },
    containerClass: {
      type: String,
      default: 'py-8'
    }
  },
  computed: {
    spinnerClass() {
      const sizeNum = parseInt(this.size)
      if (sizeNum <= 20) return 'border-2'
      if (sizeNum <= 40) return 'border-4'
      return 'border-8'
    }
  }
}
</script>