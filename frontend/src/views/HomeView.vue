<template>
  <div class="animate-fade-in">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-purple-900 text-white overflow-hidden">
      <div class="absolute inset-0 bg-black opacity-20"></div>
      <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-purple-600/20"></div>
      
      <div class="relative max-w-7xl mx-auto px-4 py-12 md:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center">
          <div class="animate-slide-up text-center lg:text-left">
            <h1 class="text-3xl md:text-4xl lg:text-6xl font-bold mb-4 md:mb-6 leading-tight">
              Discover Your
              <span class="bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                Perfect Style
              </span>
            </h1>
            <p class="text-lg md:text-xl mb-6 md:mb-8 text-gray-200 leading-relaxed">
              Shop the latest trends with premium quality products, fast shipping, and unbeatable prices. Your satisfaction is our priority.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center lg:justify-start">
              <router-link to="/products" class="px-6 md:px-8 py-3 md:py-4 text-white rounded-xl font-bold text-base md:text-lg transition-all transform hover:scale-105 shadow-lg"
                           :style="`background: linear-gradient(to right, ${settingsStore.settings.primary_color}, ${settingsStore.settings.secondary_color})`">
                Shop Now
              </router-link>
              <button class="px-6 md:px-8 py-3 md:py-4 border-2 border-white text-white rounded-xl font-semibold text-base md:text-lg hover:bg-white hover:text-gray-900 transition-all">
                Watch Demo
              </button>
            </div>
          </div>
          
          <div class="relative mt-8 lg:mt-0">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 rounded-3xl transform rotate-6 opacity-20"></div>
            <div class="relative bg-white/10 backdrop-blur-lg rounded-3xl p-4 md:p-8 border border-white/20">
              <div class="grid grid-cols-2 gap-3 md:gap-4">
                <div class="bg-white/20 rounded-xl p-3 md:p-4 text-center">
                  <i class="fas fa-shipping-fast text-xl md:text-3xl mb-1 md:mb-2"></i>
                  <p class="font-semibold text-sm md:text-base">Free Shipping</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3 md:p-4 text-center">
                  <i class="fas fa-shield-alt text-xl md:text-3xl mb-1 md:mb-2"></i>
                  <p class="font-semibold text-sm md:text-base">Secure Payment</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3 md:p-4 text-center">
                  <i class="fas fa-undo text-xl md:text-3xl mb-1 md:mb-2"></i>
                  <p class="font-semibold text-sm md:text-base">Easy Returns</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3 md:p-4 text-center">
                  <i class="fas fa-headset text-xl md:text-3xl mb-1 md:mb-2"></i>
                  <p class="font-semibold text-sm md:text-base">24/7 Support</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="py-8 md:py-16 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 text-center">
          <div class="animate-slide-up">
            <div class="text-2xl md:text-4xl font-bold text-blue-600 mb-1 md:mb-2">10M+</div>
            <div class="text-gray-600 text-sm md:text-base">Happy Customers</div>
          </div>
          <div class="animate-slide-up" style="animation-delay: 0.1s">
            <div class="text-2xl md:text-4xl font-bold text-blue-600 mb-1 md:mb-2">50K+</div>
            <div class="text-gray-600 text-sm md:text-base">Products</div>
          </div>
          <div class="animate-slide-up" style="animation-delay: 0.2s">
            <div class="text-2xl md:text-4xl font-bold text-blue-600 mb-1 md:mb-2">99.9%</div>
            <div class="text-gray-600 text-sm md:text-base">Uptime</div>
          </div>
          <div class="animate-slide-up" style="animation-delay: 0.3s">
            <div class="text-2xl md:text-4xl font-bold text-blue-600 mb-1 md:mb-2">24/7</div>
            <div class="text-gray-600 text-sm md:text-base">Support</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Products -->
    <section class="py-10 md:py-20">
      <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-8 md:mb-16">
          <h2 class="text-2xl md:text-4xl font-bold text-gray-900 mb-2 md:mb-4">Featured Products</h2>
          <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">Discover our handpicked selection of premium products that our customers love most</p>
        </div>
        
        <LoadingSpinner v-if="loading" text="Loading featured products..." size="60px" />
        
        <div v-else>
          <p class="mb-4 text-center text-gray-600 text-sm md:text-base">{{ featuredProducts.length }} featured products</p>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
            <ProductCard 
              v-for="(product, index) in featuredProducts" 
              :key="`featured-${product.id}-${index}`" 
              :product="product"
              @added-to-cart="onAddedToCart"
              class="animate-slide-up"
            />
          </div>
        </div>

        <div class="text-center mt-8 md:mt-12 space-y-3 md:space-y-4">
          <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center">
            <router-link to="/products" class="inline-flex items-center justify-center px-6 md:px-8 py-3 text-white rounded-xl font-semibold transition-colors"
                         :style="`background-color: ${settingsStore.settings.primary_color}`">
              View All Products
              <i class="fas fa-arrow-right ml-2"></i>
            </router-link>
            <router-link to="/categories" class="inline-flex items-center justify-center px-6 md:px-8 py-3 border-2 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-colors"
                         :style="`border-color: ${settingsStore.settings.primary_color}`">
              Browse Categories
              <i class="fas fa-th-large ml-2"></i>
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- Categories -->
    <section class="py-10 md:py-20 bg-gradient-to-br from-gray-50 to-blue-50">
      <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-8 md:mb-16">
          <h2 class="text-2xl md:text-4xl font-bold text-gray-900 mb-2 md:mb-4">Shop by Category</h2>
          <p class="text-lg md:text-xl text-gray-600">Find exactly what you're looking for in our organized categories</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8">
          <div v-for="(category, index) in categories.slice(0, 3)" :key="category.id" 
               class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 animate-slide-up"
               :style="`animation-delay: ${index * 0.1}s`">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-purple-500/5 rounded-2xl"></div>
            <div class="relative p-4 md:p-8 text-center">
              <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 md:mb-6 group-hover:scale-110 transition-transform">
                <i class="fas fa-laptop text-2xl md:text-3xl text-white"></i>
              </div>
              <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-2 md:mb-3">{{ category.name }}</h3>
              <p class="text-gray-600 mb-4 md:mb-6 leading-relaxed text-sm md:text-base">{{ category.description || 'Explore our collection' }}</p>
              <router-link :to="`/products?category=${category.slug}`" 
                          class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold group-hover:translate-x-2 transition-all text-sm md:text-base">
                Shop {{ category.name }}
                <i class="fas fa-arrow-right ml-2"></i>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Newsletter -->
    <section class="py-10 md:py-20 bg-gradient-to-r from-blue-600 to-purple-600">
      <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-2xl md:text-4xl font-bold text-white mb-2 md:mb-4">Stay Updated</h2>
        <p class="text-lg md:text-xl text-blue-100 mb-6 md:mb-8">Get the latest deals and product updates delivered to your inbox</p>
        <div class="flex flex-col sm:flex-row gap-3 md:gap-4 max-w-md mx-auto">
          <input type="email" placeholder="Enter your email" class="flex-1 px-4 md:px-6 py-3 rounded-xl border-0 focus:outline-none focus:ring-4 focus:ring-white/20 text-sm md:text-base">
          <button class="px-6 md:px-8 py-3 bg-white text-blue-600 rounded-xl font-semibold hover:bg-gray-100 transition-colors text-sm md:text-base">
            Subscribe
          </button>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import ProductCard from '../components/ProductCard.vue'
import LoadingSpinner from '../components/LoadingSpinner.vue'
import { useProductStore } from '../stores/products'
import { useSettingsStore } from '../stores/settings'

export default {
  name: 'HomeView',
  components: {
    ProductCard,
    LoadingSpinner
  },
  data() {
    return {
      featuredProducts: [],
      categories: [],
      loading: true
    }
  },
  setup() {
    const productStore = useProductStore()
    const settingsStore = useSettingsStore()
    return { productStore, settingsStore }
  },
  async created() {
    try {
      this.featuredProducts = await this.productStore.fetchFeaturedProducts()
      
      this.categories = await this.productStore.fetchCategories()
    } catch (error) {
      // Handle error silently
    } finally {
      this.loading = false
    }
  },
  methods: {
    onAddedToCart(product) {
      // Product added to cart
    }
  }
}
</script>