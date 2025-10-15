<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

      <div v-if="cartStore.items.length === 0" class="text-center py-16">
        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
          <i class="fas fa-shopping-cart text-4xl text-gray-400"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h2>
        <p class="text-gray-600 mb-6">Add some products to get started</p>
        <router-link to="/products" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-colors">
          Start Shopping
        </router-link>
      </div>

      <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-4">
          <div v-for="item in cartStore.items" :key="item.id" 
               class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center space-x-4">
              <img :src="item.image || 'https://via.placeholder.com/100x100'" 
                   :alt="item.name" 
                   class="w-20 h-20 object-cover rounded-lg">
              
              <div class="flex-1">
                <h3 class="font-semibold text-gray-900">{{ item.name }}</h3>
                <p class="text-gray-600">{{ item.brand }}</p>
                <p class="text-lg font-bold text-blue-600">${{ item.price }}</p>
              </div>

              <div class="flex items-center space-x-3">
                <button @click="updateQuantity(item.id, item.quantity - 1)" 
                        class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                  <i class="fas fa-minus text-gray-600"></i>
                </button>
                <span class="w-12 text-center font-semibold">{{ item.quantity }}</span>
                <button @click="updateQuantity(item.id, item.quantity + 1)" 
                        class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                  <i class="fas fa-plus text-gray-600"></i>
                </button>
              </div>

              <button @click="removeItem(item.id)" 
                      class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 h-fit">
          <h3 class="text-lg font-bold text-gray-900 mb-4">Order Summary</h3>
          
          <div class="space-y-3 mb-6">
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

          <router-link to="/checkout" 
                       class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white py-3 px-6 rounded-xl font-bold text-center hover:from-green-700 hover:to-emerald-700 transition-all transform hover:scale-105 shadow-lg flex items-center justify-center">
            <i class="fas fa-lock mr-2"></i>
            Proceed to Checkout
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useCartStore } from '../stores/cart'

export default {
  name: 'CartView',
  setup() {
    const cartStore = useCartStore()
    return { cartStore }
  },
  methods: {
    async updateQuantity(itemId, quantity) {
      if (quantity > 0) {
        await this.cartStore.updateQuantity(itemId, quantity)
      }
    },
    async removeItem(itemId) {
      await this.cartStore.removeItem(itemId)
    }
  }
}
</script>