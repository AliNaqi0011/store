<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-4 md:py-8">
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 md:gap-8">
        <!-- Mobile Tab Navigation -->
        <div class="lg:hidden">
          <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center space-x-3 mb-4">
              <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-sm md:text-lg">{{ authStore.user?.name?.charAt(0) }}</span>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900 text-sm md:text-base">{{ authStore.user?.name }}</h3>
                <p class="text-xs md:text-sm text-gray-500">{{ authStore.user?.email }}</p>
              </div>
            </div>
            
            <div class="flex space-x-2 overflow-x-auto">
              <button @click="activeTab = 'profile'" 
                      :class="activeTab === 'profile' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'text-gray-600 hover:bg-gray-50'"
                      class="flex items-center space-x-2 px-3 py-2 rounded-lg border transition-colors whitespace-nowrap text-sm">
                <i class="fas fa-user"></i>
                <span>Profile</span>
              </button>
              
              <button @click="activeTab = 'orders'" 
                      :class="activeTab === 'orders' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'text-gray-600 hover:bg-gray-50'"
                      class="flex items-center space-x-2 px-3 py-2 rounded-lg border transition-colors whitespace-nowrap text-sm">
                <i class="fas fa-shopping-bag"></i>
                <span>Orders</span>
              </button>
              
              <button @click="activeTab = 'wishlist'" 
                      :class="activeTab === 'wishlist' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'text-gray-600 hover:bg-gray-50'"
                      class="flex items-center space-x-2 px-3 py-2 rounded-lg border transition-colors whitespace-nowrap text-sm">
                <i class="fas fa-heart"></i>
                <span>Wishlist</span>
              </button>
            </div>
          </div>
        </div>
        
        <!-- Desktop Sidebar -->
        <div class="hidden lg:block lg:col-span-1">
          <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center space-x-3 mb-6">
              <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-lg">{{ authStore.user?.name?.charAt(0) }}</span>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">{{ authStore.user?.name }}</h3>
                <p class="text-sm text-gray-500">{{ authStore.user?.email }}</p>
              </div>
            </div>
            
            <nav class="space-y-2">
              <button @click="activeTab = 'profile'" 
                      :class="activeTab === 'profile' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'text-gray-600 hover:bg-gray-50'"
                      class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg border transition-colors">
                <i class="fas fa-user"></i>
                <span>Profile</span>
              </button>
              
              <button @click="activeTab = 'orders'" 
                      :class="activeTab === 'orders' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'text-gray-600 hover:bg-gray-50'"
                      class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg border transition-colors">
                <i class="fas fa-shopping-bag"></i>
                <span>Orders</span>
              </button>
              
              <button @click="activeTab = 'wishlist'" 
                      :class="activeTab === 'wishlist' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'text-gray-600 hover:bg-gray-50'"
                      class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg border transition-colors">
                <i class="fas fa-heart"></i>
                <span>Wishlist</span>
              </button>
            </nav>
          </div>
        </div>

        <!-- Content -->
        <div class="lg:col-span-3">
          <!-- Profile Tab -->
          <div v-if="activeTab === 'profile'" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 md:p-6">
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-4 md:mb-6">Profile Information</h2>
            
            <form @submit.prevent="updateProfile" class="space-y-4 md:space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                  <input v-model="profileForm.name" type="text" required
                         class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm md:text-base">
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                  <input v-model="profileForm.email" type="email" required
                         class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm md:text-base">
                </div>
              </div>
              
              <button type="submit" 
                      class="px-4 md:px-6 py-2 md:py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors text-sm md:text-base">
                Update Profile
              </button>
            </form>
          </div>

          <!-- Orders Tab -->
          <div v-if="activeTab === 'orders'" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 md:p-6">
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-4 md:mb-6">Order History</h2>
            
            <div v-if="loading" class="text-center py-12">
              <i class="fas fa-spinner fa-spin text-4xl text-gray-400 mb-4"></i>
              <p class="text-gray-600">Loading orders...</p>
            </div>
            
            <div v-else-if="orders.length === 0" class="text-center py-12">
              <i class="fas fa-shopping-bag text-4xl text-gray-400 mb-4"></i>
              <h3 class="text-lg font-semibold text-gray-900 mb-2">No orders yet</h3>
              <p class="text-gray-600 mb-6">Start shopping to see your orders here</p>
              <router-link to="/products" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                Start Shopping
              </router-link>
            </div>
            
            <div v-else class="space-y-3 md:space-y-4">
              <div v-for="order in orders" :key="order.id" 
                   class="border border-gray-200 rounded-lg p-3 md:p-4 hover:shadow-md transition-shadow">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-3 space-y-2 sm:space-y-0">
                  <div>
                    <h4 class="font-semibold text-gray-900 text-sm md:text-base">#{{ order.order_number }}</h4>
                    <p class="text-xs md:text-sm text-gray-500">{{ formatDate(order.created_at) }}</p>
                  </div>
                  <div class="text-left sm:text-right">
                    <p class="font-semibold text-gray-900 text-sm md:text-base">${{ order.total_amount }}</p>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full"
                          :class="getStatusClass(order.status)">
                      {{ order.status.toUpperCase() }}
                    </span>
                  </div>
                </div>
                
                <div class="flex items-center space-x-3 md:space-x-4">
                  <button @click="viewOrderDetails(order)" class="text-blue-600 hover:text-blue-700 text-xs md:text-sm font-medium">
                    View Details
                  </button>
                  <button v-if="order.status === 'delivered'" class="text-green-600 hover:text-green-700 text-xs md:text-sm font-medium">
                    Reorder
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Wishlist Tab -->
          <div v-if="activeTab === 'wishlist'" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 md:p-6">
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-4 md:mb-6">My Wishlist</h2>
            
            <div v-if="wishlist.length === 0" class="text-center py-12">
              <i class="fas fa-heart text-4xl text-gray-400 mb-4"></i>
              <h3 class="text-lg font-semibold text-gray-900 mb-2">Your wishlist is empty</h3>
              <p class="text-gray-600 mb-6">Save items you love for later</p>
              <router-link to="/products" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                Browse Products
              </router-link>
            </div>
            
            <div v-else class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
              <div v-for="item in wishlist" :key="item.id" 
                   class="border border-gray-200 rounded-lg p-3 md:p-4 hover:shadow-md transition-shadow">
                <img :src="item.product.image" :alt="item.product.name" 
                     class="w-full h-40 md:h-48 object-cover rounded-lg mb-3 md:mb-4">
                
                <h4 class="font-semibold text-gray-900 mb-2 text-sm md:text-base">{{ item.product.name }}</h4>
                <p class="text-base md:text-lg font-bold text-blue-600 mb-3 md:mb-4">${{ item.product.price }}</p>
                
                <div class="flex space-x-2">
                  <button class="flex-1 px-3 md:px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors text-sm md:text-base">
                    Add to Cart
                  </button>
                  <button @click="removeFromWishlist(item.id)" 
                          class="px-3 md:px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                    <i class="fas fa-trash text-sm"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Order Details Modal -->
    <div v-if="showOrderModal" class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black opacity-50" @click="closeOrderModal"></div>
        
        <div class="relative bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-screen overflow-y-auto mx-4">
          <div class="sticky top-0 bg-white border-b border-gray-200 px-4 md:px-6 py-3 md:py-4 flex items-center justify-between">
            <h3 class="text-lg md:text-xl font-bold text-gray-900">Order Details</h3>
            <button @click="closeOrderModal" class="text-gray-400 hover:text-gray-600 p-2">
              <i class="fas fa-times text-lg md:text-xl"></i>
            </button>
          </div>
          
          <div v-if="selectedOrder" class="p-4 md:p-6">
            <!-- Order Info -->
            <div class="mb-6">
              <div class="flex items-center justify-between mb-4">
                <div>
                  <h4 class="text-lg font-semibold text-gray-900">#{{ selectedOrder.order_number }}</h4>
                  <p class="text-gray-600">{{ formatDate(selectedOrder.created_at) }}</p>
                </div>
                <div class="text-right">
                  <span class="px-3 py-1 text-sm font-semibold rounded-full"
                        :class="getStatusClass(selectedOrder.status)">
                    {{ selectedOrder.status.toUpperCase() }}
                  </span>
                  <p class="text-lg font-bold text-gray-900 mt-1">${{ selectedOrder.total_amount }}</p>
                </div>
              </div>
            </div>

            <!-- Order Items -->
            <div class="mb-6">
              <h5 class="font-semibold text-gray-900 mb-3">Items Ordered</h5>
              <div class="space-y-3">
                <div v-for="item in selectedOrder.items" :key="item.id" 
                     class="flex items-center space-x-4 p-3 bg-gray-50 rounded-lg">
                  <img :src="item.product?.primary_image || 'https://via.placeholder.com/60x60'" 
                       :alt="item.product_name" 
                       class="w-12 h-12 object-cover rounded-lg">
                  <div class="flex-1">
                    <h6 class="font-medium text-gray-900">{{ item.product_name }}</h6>
                    <p class="text-sm text-gray-600">Qty: {{ item.quantity }}</p>
                  </div>
                  <div class="text-right">
                    <p class="font-semibold text-gray-900">${{ item.total }}</p>
                    <p class="text-sm text-gray-600">${{ item.price }} each</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Shipping Address -->
            <div class="mb-6">
              <h5 class="font-semibold text-gray-900 mb-3">Shipping Address</h5>
              <div class="bg-gray-50 p-4 rounded-lg">
                <p class="font-medium">{{ selectedOrder.shipping_address?.first_name }} {{ selectedOrder.shipping_address?.last_name }}</p>
                <p>{{ selectedOrder.shipping_address?.address_line_1 }}</p>
                <p v-if="selectedOrder.shipping_address?.address_line_2">{{ selectedOrder.shipping_address?.address_line_2 }}</p>
                <p>{{ selectedOrder.shipping_address?.city }}, {{ selectedOrder.shipping_address?.state }} {{ selectedOrder.shipping_address?.postal_code }}</p>
                <p>{{ selectedOrder.shipping_address?.country }}</p>
                <p class="mt-2"><strong>Phone:</strong> {{ selectedOrder.shipping_address?.phone }}</p>
              </div>
            </div>

            <!-- Order Summary -->
            <div class="mb-6">
              <h5 class="font-semibold text-gray-900 mb-3">Order Summary</h5>
              <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                <div class="flex justify-between">
                  <span>Subtotal:</span>
                  <span>${{ selectedOrder.subtotal }}</span>
                </div>
                <div class="flex justify-between">
                  <span>Tax:</span>
                  <span>${{ selectedOrder.tax_amount }}</span>
                </div>
                <div class="flex justify-between">
                  <span>Shipping:</span>
                  <span>${{ selectedOrder.shipping_amount }}</span>
                </div>
                <div v-if="selectedOrder.discount_amount > 0" class="flex justify-between text-green-600">
                  <span>Discount:</span>
                  <span>-${{ selectedOrder.discount_amount }}</span>
                </div>
                <div class="border-t pt-2 flex justify-between font-bold text-lg">
                  <span>Total:</span>
                  <span>${{ selectedOrder.total_amount }}</span>
                </div>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
              <button v-if="selectedOrder.status === 'pending' || selectedOrder.status === 'confirmed'"
                      @click="cancelOrder(selectedOrder)"
                      class="px-4 md:px-6 py-2 md:py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition-colors text-sm md:text-base">
                <i class="fas fa-times mr-2"></i>Cancel Order
              </button>
              
              <button v-if="selectedOrder.status === 'delivered'"
                      class="px-4 md:px-6 py-2 md:py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors text-sm md:text-base">
                <i class="fas fa-redo mr-2"></i>Reorder
              </button>
              
              <button @click="closeOrderModal"
                      class="px-4 md:px-6 py-2 md:py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-colors text-sm md:text-base">
                Close
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useAuthStore } from '../stores/auth'
import { useOrderStore } from '../stores/orders'
import apiClient from '../config/api'

export default {
  name: 'UserDashboard',
  data() {
    return {
      activeTab: 'profile',
      profileForm: {
        name: '',
        email: ''
      },
      orders: [],
      wishlist: [],
      loading: false,
      showOrderModal: false,
      selectedOrder: null
    }
  },
  setup() {
    const authStore = useAuthStore()
    const orderStore = useOrderStore()
    return { authStore, orderStore }
  },
  async created() {
    this.profileForm.name = this.authStore.user?.name || ''
    this.profileForm.email = this.authStore.user?.email || ''
    await this.loadOrders()
  },
  methods: {
    async loadOrders() {
      if (!this.authStore.isAuthenticated) {
        console.log('User not authenticated')
        return
      }
      
      this.loading = true
      try {
        console.log('Loading orders...')
        const response = await apiClient.get('/orders')
        console.log('Orders response:', response.data)
        this.orders = response.data.data || response.data || []
        console.log('Orders loaded:', this.orders.length)
      } catch (error) {
        console.error('Error loading orders:', error)
        this.orders = []
      } finally {
        this.loading = false
      }
    },
    
    updateProfile() {
      console.log('Updating profile:', this.profileForm)
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString()
    },
    getStatusClass(status) {
      const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        processing: 'bg-blue-100 text-blue-800',
        shipped: 'bg-purple-100 text-purple-800',
        delivered: 'bg-green-100 text-green-800',
        cancelled: 'bg-red-100 text-red-800'
      }
      return classes[status] || 'bg-gray-100 text-gray-800'
    },
    removeFromWishlist(id) {
      this.wishlist = this.wishlist.filter(item => item.id !== id)
    },

    async viewOrderDetails(order) {
      try {
        // Fetch full order details
        const response = await apiClient.get(`/orders/${order.order_number}`)
        this.selectedOrder = response.data.data || response.data
        this.showOrderModal = true
      } catch (error) {
        console.error('Error fetching order details:', error)
        alert('Failed to load order details')
      }
    },

    closeOrderModal() {
      this.showOrderModal = false
      this.selectedOrder = null
    },

    async cancelOrder(order) {
      if (!confirm(`Are you sure you want to cancel order #${order.order_number}?`)) {
        return
      }

      try {
        await apiClient.post(`/orders/${order.order_number}/cancel`)
        
        // Update order status in the list
        const orderIndex = this.orders.findIndex(o => o.id === order.id)
        if (orderIndex !== -1) {
          this.orders[orderIndex].status = 'cancelled'
        }
        
        // Update selected order if modal is open
        if (this.selectedOrder && this.selectedOrder.id === order.id) {
          this.selectedOrder.status = 'cancelled'
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