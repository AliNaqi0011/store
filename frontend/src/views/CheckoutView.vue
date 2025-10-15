<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Checkout Form -->
        <div class="space-y-6">
          <!-- Billing Information -->
          <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Billing Information</h3>
            <form class="space-y-4">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                  <input v-model="form.billing_address.first_name" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                  <input v-model="form.billing_address.last_name" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input v-model="form.billing_address.email" type="email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                <input v-model="form.billing_address.phone" type="tel" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 1 *</label>
                <input v-model="form.billing_address.address_line_1" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 2</label>
                <input v-model="form.billing_address.address_line_2" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
              <div class="grid grid-cols-3 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                  <input v-model="form.billing_address.city" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">State *</label>
                  <input v-model="form.billing_address.state" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code *</label>
                  <input v-model="form.billing_address.postal_code" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                <input v-model="form.billing_address.country" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
            </form>
          </div>

          <!-- Shipping Information -->
          <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-bold text-gray-900">Shipping Information</h3>
              <label class="flex items-center">
                <input v-model="sameAsBilling" type="checkbox" class="mr-2">
                <span class="text-sm text-gray-600">Same as billing</span>
              </label>
            </div>
            <form v-if="!sameAsBilling" class="space-y-4">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                  <input v-model="form.shipping_address.first_name" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                  <input v-model="form.shipping_address.last_name" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                <input v-model="form.shipping_address.phone" type="tel" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 1 *</label>
                <input v-model="form.shipping_address.address_line_1" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 2</label>
                <input v-model="form.shipping_address.address_line_2" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
              <div class="grid grid-cols-3 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                  <input v-model="form.shipping_address.city" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">State *</label>
                  <input v-model="form.shipping_address.state" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code *</label>
                  <input v-model="form.shipping_address.postal_code" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                <input v-model="form.shipping_address.country" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
            </form>
          </div>

          <!-- Payment Method -->
          <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Payment Method</h3>
            <div class="space-y-3">
              <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50" :class="form.payment_method === 'cod' ? 'border-blue-500 bg-blue-50' : 'border-gray-300'">
                <input v-model="form.payment_method" type="radio" value="cod" class="mr-3">
                <div class="flex items-center">
                  <i class="fas fa-money-bill-wave text-green-600 mr-3"></i>
                  <div>
                    <div class="font-medium">Cash on Delivery</div>
                    <div class="text-sm text-gray-600">Pay when you receive your order</div>
                  </div>
                </div>
              </label>
              <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50" :class="form.payment_method === 'stripe' ? 'border-blue-500 bg-blue-50' : 'border-gray-300'">
                <input v-model="form.payment_method" type="radio" value="stripe" class="mr-3">
                <div class="flex items-center">
                  <i class="fas fa-credit-card text-blue-600 mr-3"></i>
                  <div>
                    <div class="font-medium">Credit/Debit Card</div>
                    <div class="text-sm text-gray-600">Pay securely with Stripe</div>
                  </div>
                </div>
              </label>
            </div>
          </div>

          <!-- Order Notes -->
          <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Order Notes (Optional)</h3>
            <textarea v-model="form.notes" placeholder="Any special instructions for your order..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3"></textarea>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 h-fit">
          <h3 class="text-lg font-bold text-gray-900 mb-4">Order Summary</h3>
          
          <div class="space-y-4 mb-6">
            <div v-for="item in cartStore.items" :key="item.id" class="flex items-center space-x-3">
              <img :src="item.image || 'https://via.placeholder.com/60x60'" 
                   :alt="item.name" 
                   class="w-12 h-12 object-cover rounded-lg">
              <div class="flex-1">
                <h4 class="font-medium text-gray-900">{{ item.name }}</h4>
                <p class="text-sm text-gray-600">Qty: {{ item.quantity }}</p>
              </div>
              <span class="font-semibold">${{ (item.price * item.quantity).toFixed(2) }}</span>
            </div>
          </div>

          <div class="space-y-3 mb-6 pt-4 border-t">
            <div class="flex justify-between">
              <span class="text-gray-600">Subtotal</span>
              <span class="font-semibold">${{ cartStore.total.toFixed(2) }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Shipping</span>
              <span class="font-semibold">{{ cartStore.total > 100 ? 'Free' : '$10.00' }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Tax</span>
              <span class="font-semibold">${{ (cartStore.total * 0.1).toFixed(2) }}</span>
            </div>
            <div class="border-t pt-3">
              <div class="flex justify-between text-lg font-bold">
                <span>Total</span>
                <span>${{ (cartStore.total + (cartStore.total > 100 ? 0 : 10) + (cartStore.total * 0.1)).toFixed(2) }}</span>
              </div>
            </div>
          </div>

          <button @click="placeOrder" :disabled="loading" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white py-3 px-6 rounded-xl font-bold hover:from-green-700 hover:to-emerald-700 transition-all transform hover:scale-105 shadow-lg disabled:opacity-50">
            <i v-if="loading" class="fas fa-spinner fa-spin mr-2"></i>
            <i v-else-if="form.payment_method === 'cod'" class="fas fa-money-bill-wave mr-2"></i>
            <i v-else class="fas fa-credit-card mr-2"></i>
            {{ loading ? 'Processing...' : (form.payment_method === 'cod' ? 'Place Order (COD)' : 'Place Order') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, reactive, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useCartStore } from '../stores/cart'
import { useAuthStore } from '../stores/auth'
import { useToastStore } from '../stores/toast'
import apiClient from '../config/api'

export default {
  name: 'CheckoutView',
  setup() {
    const router = useRouter()
    const cartStore = useCartStore()
    const authStore = useAuthStore()
    const toastStore = useToastStore()
    
    const loading = ref(false)
    const sameAsBilling = ref(true)
    
    const form = reactive({
      billing_address: {
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
        address_line_1: '',
        address_line_2: '',
        city: '',
        state: '',
        postal_code: '',
        country: ''
      },
      shipping_address: {
        first_name: '',
        last_name: '',
        phone: '',
        address_line_1: '',
        address_line_2: '',
        city: '',
        state: '',
        postal_code: '',
        country: ''
      },
      payment_method: 'cod',
      notes: ''
    })

    // Watch for same as billing checkbox
    watch(sameAsBilling, (newVal) => {
      if (newVal) {
        form.shipping_address = { ...form.billing_address }
      }
    })

    const placeOrder = async () => {
      if (!authStore.isAuthenticated) {
        toastStore.error('Authentication Required', 'Please login to place order')
        router.push('/login')
        return
      }

      if (cartStore.items.length === 0) {
        toastStore.error('Cart Empty', 'Your cart is empty')
        return
      }

      // Validate required fields
      const requiredFields = ['first_name', 'last_name', 'email', 'phone', 'address_line_1', 'city', 'state', 'postal_code', 'country']
      for (const field of requiredFields) {
        if (!form.billing_address[field]) {
          toastStore.error('Missing Information', `Please fill in ${field.replace('_', ' ')}`)
          return
        }
      }

      if (!form.payment_method) {
        toastStore.error('Payment Method Required', 'Please select a payment method')
        return
      }

      loading.value = true

      try {
        // Copy billing to shipping if same
        if (sameAsBilling.value) {
          form.shipping_address = { ...form.billing_address }
        }

        const checkoutData = {
          ...form,
          cart_items: cartStore.items.map(item => ({
            product_id: item.product_id,
            variant_id: item.variant_id || null,
            quantity: item.quantity
          }))
        }

        const response = await apiClient.post('/checkout', checkoutData)

        if (response.data.success) {
          toastStore.success('Order Placed Successfully!', `Order Number: ${response.data.order.order_number}`)
          cartStore.clearCart()
          router.push('/orders')
        } else {
          toastStore.error('Order Failed', response.data.message || 'Failed to place order')
        }
      } catch (error) {
        let message = 'Failed to place order'
        if (error.response?.data?.message) {
          message = error.response.data.message
        } else if (error.response?.data?.errors) {
          const errors = Object.values(error.response.data.errors).flat()
          message = errors[0] || message
        }
        toastStore.error('Order Failed', message)
      } finally {
        loading.value = false
      }
    }

    return {
      cartStore,
      form,
      sameAsBilling,
      loading,
      placeOrder
    }
  }
}
</script>