<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
      <div class="text-center mb-8">
        <div class="flex items-center justify-center space-x-2 mb-6">
          <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl flex items-center justify-center">
            <i class="fas fa-shopping-bag text-white text-xl"></i>
          </div>
          <span class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
            {{ settingsStore?.settings?.site_name || 'NexShop' }}
          </span>
        </div>
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back</h2>
        <p class="text-gray-600">Sign in to your account to continue shopping</p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <form @submit.prevent="login" class="space-y-6">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
            <div class="relative">
              <input v-model="form.email" type="email" required
                     class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors"
                     placeholder="Enter your email address">
              <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
            <div class="relative">
              <input v-model="form.password" :type="showPassword ? 'text' : 'password'" required
                     class="w-full pl-12 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors"
                     placeholder="Enter your password">
              <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
              <button type="button" @click="showPassword = !showPassword"
                      class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
              </button>
            </div>
          </div>

          <div v-if="error" class="bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex items-center">
              <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
              <span class="text-red-700 text-sm">{{ error }}</span>
            </div>
          </div>

          <button type="submit" :disabled="loading"
                  class="w-full text-white py-3 px-4 rounded-xl font-semibold focus:outline-none focus:ring-4 focus:ring-blue-200 disabled:opacity-50 disabled:cursor-not-allowed transition-all transform hover:scale-105"
                  :style="`background: linear-gradient(to right, ${settingsStore.settings.primary_color}, ${settingsStore.settings.secondary_color})`">
            <span v-if="loading" class="flex items-center justify-center">
              <i class="fas fa-spinner fa-spin mr-2"></i>
              Signing In...
            </span>
            <span v-else class="flex items-center justify-center">
              <i class="fas fa-sign-in-alt mr-2"></i>
              Sign In
            </span>
          </button>
        </form>

        <div class="text-center mt-8">
          <p class="text-gray-600">
            Don't have an account?
            <router-link to="/register" class="font-semibold ml-1 hover:opacity-80"
                         :style="`color: ${settingsStore.settings.primary_color}`">
              Create one now
            </router-link>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useAuthStore } from '../stores/auth'
import { useSettingsStore } from '../stores/settings'

export default {
  name: 'LoginView',
  data() {
    return {
      form: {
        email: '',
        password: ''
      },
      loading: false,
      error: '',
      showPassword: false
    }
  },
  setup() {
    const authStore = useAuthStore()
    const settingsStore = useSettingsStore()
    return { authStore, settingsStore }
  },
  methods: {
    async login() {
      this.loading = true
      this.error = ''
      
      try {
        await this.authStore.login(this.form)
        this.$router.push('/')
      } catch (error) {
        this.error = error.response?.data?.message || 'Login failed. Please check your credentials.'
      } finally {
        this.loading = false
      }
    }
  }
}
</script>