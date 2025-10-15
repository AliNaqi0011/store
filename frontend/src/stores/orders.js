import { defineStore } from 'pinia'
import apiClient from '../config/api'

export const useOrderStore = defineStore('orders', {
  state: () => ({
    orders: [],
    currentOrder: null,
    loading: false
  }),

  actions: {
    async fetchOrders() {
      this.loading = true
      try {
        const response = await apiClient.get('/orders')
        this.orders = response.data.data || response.data
        return this.orders
      } catch (error) {
        throw error
      } finally {
        this.loading = false
      }
    },

    async fetchOrder(orderNumber) {
      this.loading = true
      try {
        const response = await apiClient.get(`/orders/${orderNumber}`)
        this.currentOrder = response.data.data || response.data
        return this.currentOrder
      } catch (error) {
        throw error
      } finally {
        this.loading = false
      }
    },

    async createOrder(orderData) {
      try {
        const response = await apiClient.post('/checkout', orderData)
        return response.data
      } catch (error) {
        throw error
      }
    },

    async cancelOrder(orderNumber) {
      try {
        this.loading = true
        this.error = null
        const response = await apiClient.post(`/orders/${orderNumber}/cancel`)
        return response.data
      } catch (error) {
        this.error = 'Failed to cancel order'
        throw error
      } finally {
        this.loading = false
      }
    }
  }
})