<template>
  <div class="mt-12">
    <div class="border-t border-gray-200 pt-8">
      <h3 class="text-2xl font-bold text-gray-900 mb-6">Customer Reviews</h3>
      
      <!-- Add Review Form -->
      <div v-if="isAuthenticated" class="bg-gray-50 rounded-xl p-6 mb-8">
        <h4 class="text-lg font-semibold mb-4">Write a Review</h4>
        <form @submit.prevent="submitReview" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
            <div class="flex space-x-1">
              <button
                v-for="star in 5"
                :key="star"
                type="button"
                @click="reviewForm.rating = star"
                class="text-2xl focus:outline-none"
                :class="star <= reviewForm.rating ? 'text-yellow-400' : 'text-gray-300'"
              >
                ★
              </button>
            </div>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
            <input
              v-model="reviewForm.title"
              type="text"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Review title"
            >
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Comment</label>
            <textarea
              v-model="reviewForm.comment"
              required
              rows="4"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Share your experience with this product"
            ></textarea>
          </div>
          
          <button
            type="submit"
            :disabled="submitting"
            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 transition-colors"
          >
            {{ submitting ? 'Submitting...' : 'Submit Review' }}
          </button>
        </form>
      </div>
      
      <!-- Reviews List -->
      <div v-if="reviews.length > 0" class="space-y-6">
        <div v-for="review in reviews" :key="review.id" class="border-b border-gray-200 pb-6">
          <div class="flex items-start justify-between mb-3">
            <div>
              <div class="flex items-center space-x-2 mb-1">
                <div class="flex text-yellow-400">
                  <span v-for="star in 5" :key="star" class="text-sm">
                    {{ star <= review.rating ? '★' : '☆' }}
                  </span>
                </div>
                <span class="text-sm text-gray-600">{{ review.rating }}/5</span>
              </div>
              <h5 class="font-semibold text-gray-900">{{ review.title }}</h5>
              <p class="text-sm text-gray-600">by {{ review.user?.name || 'Anonymous' }}</p>
            </div>
            <span class="text-sm text-gray-500">{{ formatDate(review.created_at) }}</span>
          </div>
          <p class="text-gray-700">{{ review.comment }}</p>
        </div>
      </div>
      
      <div v-else class="text-center py-8 text-gray-500">
        <p>No reviews yet. Be the first to review this product!</p>
      </div>
    </div>
  </div>
</template>

<script>
import apiClient from '../config/api'
import { useAuthStore } from '../stores/auth'
import { showNotification } from '../utils/errorHandler'

export default {
  name: 'ProductReviews',
  props: {
    productId: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      reviews: [],
      reviewForm: {
        rating: 5,
        title: '',
        comment: ''
      },
      submitting: false
    }
  },
  setup() {
    const authStore = useAuthStore()
    return { authStore }
  },
  computed: {
    isAuthenticated() {
      return this.authStore.isAuthenticated
    }
  },
  async created() {
    await this.loadReviews()
  },
  methods: {
    async loadReviews() {
      try {
        const response = await apiClient.get(`/products/${this.productId}/reviews`)
        this.reviews = response.data.data?.data || response.data.data || []
      } catch (error) {
        console.error('Failed to load reviews:', error)
      }
    },
    
    async submitReview() {
      this.submitting = true
      try {
        await apiClient.post(`/products/${this.productId}/reviews`, this.reviewForm)
        showNotification('Review submitted successfully!', 'success')
        this.reviewForm = { rating: 5, title: '', comment: '' }
        await this.loadReviews()
      } catch (error) {
        showNotification('Failed to submit review', 'error')
      } finally {
        this.submitting = false
      }
    },
    
    formatDate(date) {
      return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    }
  }
}
</script>