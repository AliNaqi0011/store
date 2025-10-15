import { defineStore } from 'pinia'
import apiClient from '../config/api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: sessionStorage.getItem('auth_token'),
    isAuthenticated: !!sessionStorage.getItem('auth_token'),
    loading: false,
    error: null
  }),

  actions: {
    async login(credentials) {
      try {
        this.loading = true
        this.error = null
        const response = await apiClient.post('/login', credentials)
        this.token = response.data.token
        this.user = response.data.user
        this.isAuthenticated = true
        sessionStorage.setItem('auth_token', this.token)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Login failed'
        throw error
      } finally {
        this.loading = false
      }
    },

    async register(userData) {
      try {
        this.loading = true
        this.error = null
        const response = await apiClient.post('/register', userData)
        this.token = response.data.token
        this.user = response.data.user
        this.isAuthenticated = true
        sessionStorage.setItem('auth_token', this.token)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Registration failed'
        throw error
      } finally {
        this.loading = false
      }
    },

    async logout() {
      try {
        this.loading = true
        await apiClient.post('/logout')
      } catch (error) {
        console.error('Logout error:', error)
      } finally {
        this.user = null
        this.token = null
        this.isAuthenticated = false
        this.loading = false
        this.error = null
        sessionStorage.removeItem('auth_token')
      }
    },

    async fetchUser() {
      try {
        this.loading = true
        this.error = null
        const response = await apiClient.get('/user')
        this.user = response.data
        this.isAuthenticated = true
      } catch (error) {
        // Don't logout immediately, just set auth state to false
        this.user = null
        this.isAuthenticated = false
        this.error = null // Don't show error for failed auth check
      } finally {
        this.loading = false
      }
    }
  }
})