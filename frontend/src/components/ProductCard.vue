<template>
  <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
    <div class="relative overflow-hidden">
      <img :src="getImageUrl(product)" 
           :alt="product.name" 
           @error="handleImageError"
           class="w-full h-48 md:h-64 object-cover group-hover:scale-110 transition-transform duration-500">
      
      <!-- Badges -->
      <div class="absolute top-4 left-4 flex flex-col gap-2">
        <span v-if="product.is_featured" class="px-3 py-1 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold rounded-full">
          FEATURED
        </span>
        <span v-if="product.compare_price" class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full">
          SALE
        </span>
      </div>
      
      <!-- Quick Actions -->
      <div class="absolute top-3 md:top-4 right-3 md:right-4 flex flex-col gap-2 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
        <button @click="toggleWishlist" 
                class="w-8 h-8 md:w-10 md:h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-colors">
          <i class="fas fa-heart text-sm md:text-base" :class="inWishlist ? 'text-red-500' : 'text-gray-400'"></i>
        </button>
        <button class="w-8 h-8 md:w-10 md:h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-colors">
          <i class="fas fa-eye text-gray-600 text-sm md:text-base"></i>
        </button>
      </div>

      <!-- Quick Add to Cart -->
      <div class="absolute bottom-3 md:bottom-4 left-3 md:left-4 right-3 md:right-4 opacity-100 md:opacity-0 group-hover:opacity-100 transition-all transform translate-y-0 md:translate-y-4 group-hover:translate-y-0">
        <button @click="addToCart" 
                :disabled="!product.in_stock"
                class="w-full py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors text-sm md:text-base">
          <i class="fas fa-cart-plus mr-2"></i>
          <span class="hidden sm:inline">{{ product.in_stock ? 'Add to Cart' : 'Out of Stock' }}</span>
          <span class="sm:hidden">{{ product.in_stock ? 'Add' : 'Out' }}</span>
        </button>
      </div>
    </div>
    
    <div class="p-4 md:p-6">
      <!-- Category & Brand -->
      <div class="flex items-center justify-between mb-2">
        <span class="text-xs md:text-sm text-blue-600 font-medium truncate">{{ product.category }}</span>
        <span v-if="product.brand" class="text-xs md:text-sm text-gray-500 truncate ml-2">{{ product.brand }}</span>
      </div>
      
      <!-- Product Name -->
      <h3 class="font-bold text-base md:text-lg text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
        <router-link :to="`/product/${product.slug}`">
          {{ product.name }}
        </router-link>
      </h3>
      
      <!-- Description -->
      <p class="text-gray-600 text-xs md:text-sm mb-3 md:mb-4 line-clamp-2">{{ product.short_description }}</p>
      
      <!-- Rating -->
      <div class="flex items-center mb-3 md:mb-4">
        <div class="flex text-yellow-400 mr-2">
          <i v-for="n in 5" :key="n" 
             class="fas fa-star text-xs md:text-sm" 
             :class="n <= Math.floor(product.rating || 4.5) ? 'text-yellow-400' : 'text-gray-300'"></i>
        </div>
        <span class="text-xs md:text-sm text-gray-500">({{ product.reviews_count || 0 }})</span>
        <div class="ml-auto">
          <span v-if="!product.in_stock" class="text-xs text-red-500 font-medium">Out of Stock</span>
          <span v-else-if="product.stock_quantity < 10" class="text-xs text-orange-500 font-medium hidden sm:inline">Only {{ product.stock_quantity }} left</span>
          <span v-else-if="product.stock_quantity < 10" class="text-xs text-orange-500 font-medium sm:hidden">{{ product.stock_quantity }} left</span>
        </div>
      </div>
      
      <!-- Price -->
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-1 md:space-x-2">
          <span class="text-lg md:text-2xl font-bold text-gray-900">${{ product.price }}</span>
          <span v-if="product.compare_price" class="text-sm md:text-lg text-gray-500 line-through">${{ product.compare_price }}</span>
        </div>
        
        <!-- Discount Percentage -->
        <div v-if="product.compare_price" class="text-xs md:text-sm font-bold text-green-600">
          {{ Math.round(((product.compare_price - product.price) / product.compare_price) * 100) }}% OFF
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useCartStore } from '../stores/cart'

export default {
  name: 'ProductCard',
  props: {
    product: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      inWishlist: false
    }
  },
  setup() {
    const cartStore = useCartStore()
    return { cartStore }
  },
  methods: {
    getImageUrl(product) {
      if (product.primary_image && product.primary_image !== null && product.primary_image !== '') {
        // If it's a relative path, make it absolute with backend URL
        if (product.primary_image.startsWith('/storage/')) {
          return `http://127.0.0.1:8000${product.primary_image}`
        }
        return product.primary_image
      }
      // Fallback to a reliable dummy image service
      return `https://dummyimage.com/400x300/4f46e5/ffffff&text=${encodeURIComponent(product.name || 'Product')}`
    },
    handleImageError(event) {
      // Try the dummy image service first
      const fallbackUrl = `https://dummyimage.com/400x300/4f46e5/ffffff&text=${encodeURIComponent(this.product.name)}`
      
      // If this is already the fallback URL, create canvas
      if (event.target.src.includes('dummyimage.com')) {
        const canvas = document.createElement('canvas')
        canvas.width = 400
        canvas.height = 300
        const ctx = canvas.getContext('2d')
        
        // Background
        ctx.fillStyle = '#f3f4f6'
        ctx.fillRect(0, 0, 400, 300)
        
        // Text
        ctx.fillStyle = '#374151'
        ctx.font = '16px Arial'
        ctx.textAlign = 'center'
        ctx.textBaseline = 'middle'
        ctx.fillText(this.product.name, 200, 150)
        
        event.target.src = canvas.toDataURL()
      } else {
        // Try the dummy image service
        event.target.src = fallbackUrl
      }
    },
    async addToCart(event) {
      try {
        await this.cartStore.addItem(this.product.id, null, 1)
        this.$emit('added-to-cart', this.product)
        
        // Visual feedback
        const button = event.target
        const originalText = button.innerHTML
        button.innerHTML = '<i class="fas fa-check mr-2"></i><span class="hidden sm:inline">Added!</span><span class="sm:hidden">✓</span>'
        button.classList.add('bg-green-600')
        
        setTimeout(() => {
          button.innerHTML = originalText
          button.classList.remove('bg-green-600')
        }, 2000)
      } catch (error) {
        alert('Failed to add item to cart. Please try again.')
      }
    },
    toggleWishlist() {
      this.inWishlist = !this.inWishlist
    }
  }
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>