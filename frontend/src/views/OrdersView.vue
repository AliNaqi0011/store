<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-8">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Orders</h1>
        <p class="text-gray-600">Track and manage your orders</p>
      </div>

      <LoadingSkeleton v-if="loading" />
      
      <div v-else-if="orders.length > 0" class="space-y-6">
        <div v-for="order in orders" :key="order.id" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
            <div>
              <h3 class="text-lg font-semibold text-gray-900">Order #{{ order.order_number }}</h3>
              <p class="text-gray-600">{{ formatDate(order.created_at) }}</p>
            </div>
            <div class="flex items-center space-x-4 mt-4 md:mt-0">
              <span :class="getStatusClass(order.status)" class="px-3 py-1 rounded-full text-sm font-medium">
                {{ order.status.toUpperCase() }}
              </span>
              <span class="text-lg font-bold text-gray-900">${{ order.total }}</span>
            </div>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
              <p class="text-sm text-gray-500">Payment Method</p>
              <p class="font-medium">{{ order.payment_method?.toUpperCase() || 'COD' }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Items</p>
              <p class="font-medium">{{ order.items?.length || 0 }} items</p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Delivery Address</p>
              <p class="font-medium">{{ order.shipping_address?.city || 'N/A' }}</p>
            </div>
          </div>
          
          <div class="flex justify-between items-center pt-4 border-t border-gray-200">
            <router-link 
              :to="`/orders/${order.order_number}`"
              class="text-blue-600 hover:text-blue-700 font-medium"
            >
              View Details
            </router-link>
            <div class="space-x-2">
              <button 
                v-if="order.status === 'pending' || order.status === 'confirmed'"
                @click="cancelOrder(order)"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
              >
                Cancel Order
              </button>
              <button 
                v-if="order.status === 'delivered'"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
              >
                Reorder
              </button>
            </div>
          </div>
        </div>
      </div>
      
      <div v-else class="text-center py-16">
        <div class="text-gray-500">
          <i class="fas fa-shopping-bag text-4xl mb-4"></i>
          <h3 class="text-lg font-semibold mb-2">No orders yet</h3>
          <p class="mb-6">Start shopping to see your orders here</p>
          <router-link 
            to="/products" 
            class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors"
          >
            Start Shopping
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import LoadingSkeleton from '../components/LoadingSkeleton.vue'
import { useOrderStore } from '../stores/orders'
import { handleApiError } from '../utils/errorHandler'

export default {
  name: 'OrdersView',
  components: {
    LoadingSkeleton
  },
  data() {
    return {
      orders: [],
      loading: true
    }
  },
  setup() {
    const orderStore = useOrderStore()
    return { orderStore }
  },
  async created() {
    await this.loadOrders()
  },
  methods: {
    async loadOrders() {
      this.loading = true
      try {
        this.orders = await this.orderStore.fetchOrders()
      } catch (error) {
        handleApiError(error)
      } finally {
        this.loading = false
      }
    },
    
    formatDate(date) {
      return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    },
    
    getStatusClass(status) {
      const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        processing: 'bg-blue-100 text-blue-800',
        shipped: 'bg-purple-100 text-purple-800',
        delivered: 'bg-green-100 text-green-800',
        cancelled: 'bg-red-100 text-red-800',
        confirmed: 'bg-green-100 text-green-800'
      }
      return classes[status] || 'bg-gray-100 text-gray-800'
    },

    async cancelOrder(order) {
      if (!confirm(`Are you sure you want to cancel order #${order.order_number}?`)) {
        return
      }

      try {
        await this.orderStore.cancelOrder(order.order_number)
        // Update the order status in the list
        const orderIndex = this.orders.findIndex(o => o.id === order.id)
        if (orderIndex !== -1) {
          this.orders[orderIndex].status = 'cancelled'
        }
        alert('Order cancelled successfully!')
      } catch (error) {
        console.error('Error cancelling order:', error)
        alert('Failed to cancel order. Please try again.')
      }
    }
  }
}
</script>