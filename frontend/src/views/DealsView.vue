<template>
  <div class="min-h-screen bg-white">
    <!-- Hero Section - Sapphire Luxury Style -->
    <div class="relative bg-gradient-to-b from-slate-50 to-white">
      <div class="absolute inset-0 opacity-50" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23f1f5f9&quot; fill-opacity=&quot;0.4&quot;%3E%3Ccircle cx=&quot;30&quot; cy=&quot;30&quot; r=&quot;1.5&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
      <div class="relative max-w-7xl mx-auto px-4 py-20">
        <div class="text-center">
          <div class="inline-flex items-center bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-2 rounded-full text-sm font-medium mb-6 shadow-lg">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            EXCLUSIVE OFFERS
          </div>
          <h1 class="text-5xl md:text-6xl font-light text-slate-900 mb-6 tracking-tight">
            Premium <span class="font-semibold text-blue-600">Deals</span>
          </h1>
          <p class="text-xl text-slate-600 max-w-3xl mx-auto mb-12 leading-relaxed">
            Discover exceptional savings on our curated collection of premium products. 
            Limited-time offers on luxury items you'll love.
          </p>
          
          <!-- Countdown Timer - Luxury Style -->
          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-2xl p-8 inline-block shadow-xl">
            <div class="text-slate-700 text-sm font-medium mb-4 uppercase tracking-wider">Offer Expires In</div>
            <div class="flex space-x-6">
              <div class="text-center">
                <div class="text-3xl font-light text-slate-900 mb-1">{{ countdown.hours }}</div>
                <div class="text-xs text-slate-500 uppercase tracking-wider">Hours</div>
              </div>
              <div class="text-slate-300 text-2xl">:</div>
              <div class="text-center">
                <div class="text-3xl font-light text-slate-900 mb-1">{{ countdown.minutes }}</div>
                <div class="text-xs text-slate-500 uppercase tracking-wider">Minutes</div>
              </div>
              <div class="text-slate-300 text-2xl">:</div>
              <div class="text-center">
                <div class="text-3xl font-light text-slate-900 mb-1">{{ countdown.seconds }}</div>
                <div class="text-xs text-slate-500 uppercase tracking-wider">Seconds</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-16">
      <!-- Deal Categories - Sapphire Luxury Style -->
      <div class="mb-20">
        <div class="text-center mb-16">
          <h2 class="text-4xl font-light text-slate-900 mb-4 tracking-tight">Curated Collections</h2>
          <div class="w-24 h-px bg-gradient-to-r from-transparent via-blue-600 to-transparent mx-auto mb-6"></div>
          <p class="text-lg text-slate-600 max-w-2xl mx-auto">Explore our carefully selected categories of premium deals</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div class="group cursor-pointer">
            <div class="bg-white border border-slate-200 rounded-3xl p-8 text-center hover:shadow-2xl hover:border-blue-200 transition-all duration-500 transform hover:-translate-y-2">
              <div class="w-16 h-16 bg-gradient-to-br from-red-50 to-red-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:from-red-100 group-hover:to-red-200 transition-all duration-300">
                <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                  <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                </svg>
              </div>
              <h3 class="text-xl font-medium text-slate-900 mb-2">Flash Sales</h3>
              <p class="text-slate-500 text-sm leading-relaxed">Limited time offers on premium items</p>
            </div>
          </div>
          <div class="group cursor-pointer">
            <div class="bg-white border border-slate-200 rounded-3xl p-8 text-center hover:shadow-2xl hover:border-blue-200 transition-all duration-500 transform hover:-translate-y-2">
              <div class="w-16 h-16 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:from-blue-100 group-hover:to-blue-200 transition-all duration-300">
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                </svg>
              </div>
              <h3 class="text-xl font-medium text-slate-900 mb-2">Clearance</h3>
              <p class="text-slate-500 text-sm leading-relaxed">Up to 70% off selected luxury items</p>
            </div>
          </div>
          <div class="group cursor-pointer">
            <div class="bg-white border border-slate-200 rounded-3xl p-8 text-center hover:shadow-2xl hover:border-blue-200 transition-all duration-500 transform hover:-translate-y-2">
              <div class="w-16 h-16 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:from-emerald-100 group-hover:to-emerald-200 transition-all duration-300">
                <svg class="w-8 h-8 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z" clip-rule="evenodd"/>
                  <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z"/>
                </svg>
              </div>
              <h3 class="text-xl font-medium text-slate-900 mb-2">Bundle Deals</h3>
              <p class="text-slate-500 text-sm leading-relaxed">Curated collections at special prices</p>
            </div>
          </div>
          <div class="group cursor-pointer">
            <div class="bg-white border border-slate-200 rounded-3xl p-8 text-center hover:shadow-2xl hover:border-blue-200 transition-all duration-500 transform hover:-translate-y-2">
              <div class="w-16 h-16 bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:from-purple-100 group-hover:to-purple-200 transition-all duration-300">
                <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
              </div>
              <h3 class="text-xl font-medium text-slate-900 mb-2">VIP Exclusive</h3>
              <p class="text-slate-500 text-sm leading-relaxed">Members-only premium offers</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Featured Deals - Sapphire Luxury Cards -->
      <div class="mb-20">
        <div class="text-center mb-16">
          <h2 class="text-4xl font-light text-slate-900 mb-4 tracking-tight">Featured Offers</h2>
          <div class="w-24 h-px bg-gradient-to-r from-transparent via-blue-600 to-transparent mx-auto mb-6"></div>
          <p class="text-lg text-slate-600 max-w-2xl mx-auto">Handpicked premium deals with exceptional value</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="deal in featuredDeals" :key="deal.id" class="group cursor-pointer">
            <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden hover:shadow-2xl hover:border-blue-200 transition-all duration-500 transform hover:-translate-y-2">
              <div class="relative overflow-hidden">
                <img :src="deal.image" :alt="deal.name" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="absolute top-4 left-4">
                  <span class="bg-gradient-to-r from-red-600 to-red-700 text-white px-3 py-1.5 rounded-full text-sm font-medium shadow-lg">
                    {{ deal.discount }}% OFF
                  </span>
                </div>
                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-lg">
                  <span class="text-xs font-medium text-slate-700">{{ deal.timeLeft }}</span>
                </div>
              </div>
              <div class="p-8">
                <h3 class="text-xl font-medium text-slate-900 mb-3 line-clamp-2 leading-relaxed">{{ deal.name }}</h3>
                <div class="flex items-baseline space-x-3 mb-6">
                  <span class="text-3xl font-light text-slate-900">${{ deal.salePrice }}</span>
                  <span class="text-lg text-slate-400 line-through">${{ deal.originalPrice }}</span>
                </div>
                <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 border border-emerald-200 rounded-2xl p-4 mb-6">
                  <span class="text-emerald-800 text-sm font-medium">
                    Save ${{ (deal.originalPrice - deal.salePrice).toFixed(2) }}
                  </span>
                </div>
                <div class="mb-6">
                  <div class="flex justify-between text-sm text-slate-600 mb-3">
                    <span>{{ deal.sold }} sold</span>
                    <span>{{ deal.stock }} remaining</span>
                  </div>
                  <div class="w-full bg-slate-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-2 rounded-full transition-all duration-500" :style="`width: ${(deal.sold / (deal.sold + deal.stock)) * 100}%`"></div>
                  </div>
                </div>
                <button @click="addToCart(deal)" class="w-full bg-gradient-to-r from-slate-900 to-slate-800 text-white py-4 rounded-2xl font-medium hover:from-slate-800 hover:to-slate-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                  Add to Cart
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Daily Deals -->
      <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-3xl p-12 text-white text-center mb-16">
        <h2 class="text-4xl font-bold mb-4">⚡ Daily Lightning Deals</h2>
        <p class="text-xl text-purple-100 mb-8">New deals every day at 12:00 PM</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="bg-white bg-opacity-20 rounded-2xl p-6">
            <div class="text-3xl mb-2">📱</div>
            <h3 class="font-bold mb-2">Electronics</h3>
            <p class="text-sm opacity-90">Up to 60% off smartphones, laptops & more</p>
          </div>
          <div class="bg-white bg-opacity-20 rounded-2xl p-6">
            <div class="text-3xl mb-2">👕</div>
            <h3 class="font-bold mb-2">Fashion</h3>
            <p class="text-sm opacity-90">50% off trending clothing & accessories</p>
          </div>
          <div class="bg-white bg-opacity-20 rounded-2xl p-6">
            <div class="text-3xl mb-2">🏠</div>
            <h3 class="font-bold mb-2">Home & Garden</h3>
            <p class="text-sm opacity-90">40% off furniture & home decor</p>
          </div>
        </div>
      </div>

      <!-- Newsletter Signup -->
      <div class="bg-white rounded-3xl shadow-xl p-12 text-center">
        <div class="w-20 h-20 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
          <i class="fas fa-bell text-white text-3xl"></i>
        </div>
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Never Miss a Deal!</h2>
        <p class="text-xl text-gray-600 mb-8">Get notified about flash sales and exclusive offers</p>
        <div class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
          <input type="email" placeholder="Enter your email" class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-orange-500">
          <button class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-3 rounded-xl font-bold hover:from-orange-600 hover:to-red-600 transition-all">
            Subscribe
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useCartStore } from '../stores/cart'
import { useToastStore } from '../stores/toast'

export default {
  name: 'DealsView',
  data() {
    return {
      countdown: {
        hours: 23,
        minutes: 45,
        seconds: 30
      },
      featuredDeals: []
    }
  },
  setup() {
    const cartStore = useCartStore()
    const toastStore = useToastStore()
    return { cartStore, toastStore }
  },
  mounted() {
    this.startCountdown()
    this.fetchDeals()
  },
  methods: {
    startCountdown() {
      setInterval(() => {
        if (this.countdown.seconds > 0) {
          this.countdown.seconds--
        } else if (this.countdown.minutes > 0) {
          this.countdown.minutes--
          this.countdown.seconds = 59
        } else if (this.countdown.hours > 0) {
          this.countdown.hours--
          this.countdown.minutes = 59
          this.countdown.seconds = 59
        }
      }, 1000)
    },
    async fetchDeals() {
      try {
        const response = await fetch('/api/deals/featured')
        const data = await response.json()
        if (data.success) {
          this.featuredDeals = data.data.map(deal => ({
            id: deal.id,
            productId: deal.product.id,
            name: deal.product.name,
            image: deal.product.image || 'https://via.placeholder.com/400x300?text=Product',
            originalPrice: parseFloat(deal.original_price),
            salePrice: parseFloat(deal.sale_price),
            discount: deal.discount_percentage,
            timeLeft: deal.time_left,
            sold: Math.floor(Math.random() * 50) + 10,
            stock: Math.floor(Math.random() * 100) + 20
          }))
        }
      } catch (error) {
        console.error('Error fetching deals:', error)
      }
    },
    async addToCart(deal) {
      try {
        await this.cartStore.addItem(deal.productId, null, 1)
        this.toastStore.success(`${deal.name} added to cart!`)
      } catch (error) {
        console.error('Cart error:', error)
        this.toastStore.error('Failed to add item to cart')
      }
    }
  }
}
</script>

<style scoped>
@keyframes bounce-in {
  0% {
    opacity: 0;
    transform: scale(0.3);
  }
  50% {
    opacity: 1;
    transform: scale(1.05);
  }
  70% {
    transform: scale(0.9);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

.animate-bounce-in {
  animation: bounce-in 1s ease-out;
}
</style>