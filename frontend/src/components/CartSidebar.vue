<template>
  <div>
    <!-- Backdrop -->
    <Transition name="backdrop">
      <div v-if="cartStore.isOpen" class="fixed inset-0 z-50 overflow-hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="cartStore.toggleCart()"></div>
        
        <!-- Sidebar -->
        <Transition name="slide">
          <div class="absolute right-0 top-0 h-full w-full sm:max-w-md bg-white shadow-2xl flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 md:p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-purple-50">
              <div class="flex items-center space-x-2 md:space-x-3">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                  <i class="fas fa-shopping-cart text-white text-sm md:text-base"></i>
                </div>
                <div>
                  <h2 class="text-lg md:text-xl font-bold text-gray-900">Shopping Cart</h2>
                  <p class="text-xs md:text-sm text-gray-500">{{ cartStore.count }} items</p>
                </div>
              </div>
              <button @click="cartStore.toggleCart()" class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                <i class="fas fa-times text-gray-600 text-sm md:text-base"></i>
              </button>
            </div>
            
            <!-- Empty State -->
            <div v-if="cartStore.items.length === 0" class="flex-1 flex flex-col items-center justify-center p-4 md:p-8 text-center">
              <div class="w-16 h-16 md:w-24 md:h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4 md:mb-6">
                <i class="fas fa-shopping-cart text-2xl md:text-4xl text-gray-400"></i>
              </div>
              <h3 class="text-lg md:text-xl font-semibold text-gray-900 mb-2">Your cart is empty</h3>
              <p class="text-gray-500 mb-4 md:mb-6 text-sm md:text-base">Add some products to get started</p>
              <router-link to="/products" @click="cartStore.toggleCart()" 
                          class="px-4 md:px-6 py-2 md:py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all text-sm md:text-base">
                Start Shopping
              </router-link>
            </div>
            
            <!-- Cart Items -->
            <div v-else class="flex-1 overflow-y-auto p-4 md:p-6 space-y-3 md:space-y-4">
              <div v-for="item in cartStore.items" :key="item.id" 
                   class="flex items-center space-x-3 md:space-x-4 p-3 md:p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                <div class="relative">
                  <img :src="item.image || 'https://via.placeholder.com/80x80'" 
                       :alt="item.name" 
                       class="w-12 h-12 md:w-16 md:h-16 object-cover rounded-lg">
                  <div class="absolute -top-1 -right-1 md:-top-2 md:-right-2 w-5 h-5 md:w-6 md:h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">
                    {{ item.quantity }}
                  </div>
                </div>
                
                <div class="flex-1 min-w-0">
                  <h3 class="font-semibold text-gray-900 truncate text-sm md:text-base">{{ item.name }}</h3>
                  <p class="text-xs md:text-sm text-gray-500">{{ item.brand }}</p>
                  <div class="flex items-center justify-between mt-1 md:mt-2">
                    <span class="font-bold text-blue-600 text-sm md:text-base">${{ item.price }}</span>
                    <div class="flex items-center space-x-1 md:space-x-2">
                      <button @click="updateQuantity(item.id, item.quantity - 1)" 
                              class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition-colors">
                        <i class="fas fa-minus text-xs text-gray-600"></i>
                      </button>
                      <span class="w-6 md:w-8 text-center font-semibold text-sm md:text-base">{{ item.quantity }}</span>
                      <button @click="updateQuantity(item.id, item.quantity + 1)" 
                              class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition-colors">
                        <i class="fas fa-plus text-xs text-gray-600"></i>
                      </button>
                    </div>
                  </div>
                </div>
                
                <button @click="removeItem(item.id)" 
                        class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-red-100 hover:bg-red-200 flex items-center justify-center transition-colors group">
                  <i class="fas fa-trash text-red-500 text-xs md:text-sm group-hover:scale-110 transition-transform"></i>
                </button>
              </div>
            </div>
            
            <!-- Footer -->
            <div v-if="cartStore.items.length > 0" class="border-t border-gray-200 p-4 md:p-6 bg-gray-50">
              <!-- Totals -->
              <div class="space-y-1 md:space-y-2 mb-4 md:mb-6">
                <div class="flex justify-between text-gray-600 text-sm md:text-base">
                  <span>Subtotal</span>
                  <span>${{ cartStore.total.toFixed(2) }}</span>
                </div>
                <div class="flex justify-between text-gray-600 text-sm md:text-base">
                  <span>Shipping</span>
                  <span>{{ cartStore.total > 100 ? 'Free' : '$10.00' }}</span>
                </div>
                <div class="flex justify-between text-gray-600 text-sm md:text-base">
                  <span>Tax</span>
                  <span>${{ (cartStore.total * 0.1).toFixed(2) }}</span>
                </div>
                <div class="border-t pt-1 md:pt-2">
                  <div class="flex justify-between font-bold text-base md:text-lg text-gray-900">
                    <span>Total</span>
                    <span>${{ (cartStore.total + (cartStore.total > 100 ? 0 : 10) + (cartStore.total * 0.1)).toFixed(2) }}</span>
                  </div>
                </div>
              </div>
              
              <!-- Actions -->
              <div class="space-y-2 md:space-y-3">
                <router-link to="/checkout" @click="cartStore.toggleCart()" 
                            class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white py-3 md:py-4 px-4 md:px-6 rounded-xl font-bold text-center hover:from-green-700 hover:to-emerald-700 transition-all transform hover:scale-105 shadow-lg flex items-center justify-center text-sm md:text-base">
                  <i class="fas fa-lock mr-2"></i>
                  Secure Checkout
                </router-link>
                <router-link to="/cart" @click="cartStore.toggleCart()" 
                            class="w-full bg-white border-2 border-gray-200 text-gray-700 py-2 md:py-3 px-4 md:px-6 rounded-xl font-semibold text-center hover:bg-gray-50 transition-colors flex items-center justify-center text-sm md:text-base">
                  <i class="fas fa-shopping-cart mr-2"></i>
                  View Full Cart
                </router-link>
              </div>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </div>
</template>

<script>
import { useCartStore } from '../stores/cart'

export default {
  name: 'CartSidebar',
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

<style scoped>
.backdrop-enter-active, .backdrop-leave-active {
  transition: opacity 0.3s ease;
}
.backdrop-enter-from, .backdrop-leave-to {
  opacity: 0;
}

.slide-enter-active, .slide-leave-active {
  transition: transform 0.3s ease;
}
.slide-enter-from, .slide-leave-to {
  transform: translateX(100%);
}
</style>