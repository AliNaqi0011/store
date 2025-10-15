<template>
  <div class="skeleton" :style="skeletonStyle" :aria-label="ariaLabel">
    <span class="sr-only">Loading...</span>
  </div>
</template>

<script>
export default {
  name: 'LoadingSkeleton',
  props: {
    type: {
      type: String,
      default: 'text',
      validator: (value) => ['text', 'product-card', 'avatar', 'image'].includes(value)
    },
    width: {
      type: String,
      default: '100%'
    },
    height: {
      type: String,
      default: '1rem'
    }
  },
  computed: {
    skeletonStyle() {
      const styles = {
        text: { width: this.width, height: this.height, borderRadius: '4px' },
        'product-card': { width: '100%', height: '300px', borderRadius: '8px' },
        avatar: { width: '40px', height: '40px', borderRadius: '50%' },
        image: { width: this.width, height: this.height, borderRadius: '8px' }
      }
      return styles[this.type] || styles.text
    },
    ariaLabel() {
      return `Loading ${this.type}`
    }
  }
}
</script>