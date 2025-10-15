<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-8">
      <div v-if="loading" class="flex justify-center py-16">
        <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-blue-600"></div>
      </div>

      <div v-else-if="product" class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
          <!-- Product Image -->
          <div class="space-y-4">
            <div class="aspect-square bg-gray-100 rounded-xl overflow-hidden">
              <img :src="getImageUrl(product)" 
                   :alt="product.name" 
                   @error="handleImageError"
                   class="w-full h-full object-cover">
            </div>
          </div>

          <!-- Product Info -->
          <div class="space-y-6">
            <div>
              <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ product.name }}</h1>
              <p class="text-gray-600">{{ product.short_description }}</p>
            </div>

            <div class="flex items-center space-x-4">
              <div class="flex text-yellow-400">
                <i v-for="n in 5" :key="n" 
                   class="fas fa-star" 
                   :class="n <= Math.floor(product.rating || 4.5) ? 'text-yellow-400' : 'text-gray-300'"></i>
              </div>
              <span class="text-gray-600">({{ product.reviews_count || 0 }} reviews)</span>
            </div>

            <div class="flex items-center space-x-4">
              <span class="text-4xl font-bold text-gray-900">${{ product.price }}</span>
              <span v-if="product.compare_price" class="text-2xl text-gray-500 line-through">${{ product.compare_price }}</span>
              <span v-if="product.compare_price" class="px-3 py-1 bg-red-100 text-red-800 text-sm font-bold rounded-full">
                {{ Math.round(((product.compare_price - product.price) / product.compare_price) * 100) }}% OFF
              </span>
            </div>

            <div class="prose max-w-none">
              <p>{{ product.description }}</p>
            </div>

            <div class="flex items-center space-x-4">
              <button @click="addToCart" 
                      :disabled="!product.in_stock"
                      class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 px-8 rounded-xl font-bold text-lg hover:from-blue-700 hover:to-purple-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all transform hover:scale-105">
                <i class="fas fa-cart-plus mr-2"></i>
                {{ product.in_stock ? 'Add to Cart' : 'Out of Stock' }}
              </button>
              
              <button class="p-4 border-2 border-gray-200 rounded-xl hover:border-red-300 hover:text-red-500 transition-colors">
                <i class="fas fa-heart text-xl"></i>
              </button>
            </div>

            <div class="grid grid-cols-3 gap-4 pt-6 border-t">
              <div class="text-center">
                <i class="fas fa-shipping-fast text-2xl text-blue-600 mb-2"></i>
                <p class="text-sm font-medium">Free Shipping</p>
              </div>
              <div class="text-center">
                <i class="fas fa-undo text-2xl text-green-600 mb-2"></i>
                <p class="text-sm font-medium">Easy Returns</p>
              </div>
              <div class="text-center">
                <i class="fas fa-shield-alt text-2xl text-purple-600 mb-2"></i>
                <p class="text-sm font-medium">Secure Payment</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="text-center py-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Product not found</h2>
        <p class="text-gray-600 mb-6">The product you're looking for doesn't exist.</p>
        <router-link to="/products" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-colors">
          Browse Products
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import { useProductStore } from '../stores/products'
import { useCartStore } from '../stores/cart'

export default {
  name: 'ProductDetailView',
  data() {
    return {
      product: null,
      loading: true
    }
  },
  setup() {
    const productStore = useProductStore()
    const cartStore = useCartStore()
    return { productStore, cartStore }
  },
  async created() {
    await this.loadProduct()
  },
  methods: {
    async loadProduct() {
      this.loading = true
      try {
        this.product = await this.productStore.fetchProduct(this.$route.params.slug)
        console.log('Product detail loaded:', this.product)
        console.log('Product primary_image:', this.product?.primary_image)
        console.log('Product in_stock:', this.product?.in_stock)
        console.log('Product stock_quantity:', this.product?.stock_quantity)
      } catch (error) {
        console.error('Error loading product:', error)
      } finally {
        this.loading = false
      }
    },
    getImageUrl(product) {
      console.log('ProductDetail getImageUrl called with:', product?.name, product?.primary_image)
      
      if (product && product.primary_image && product.primary_image !== null && product.primary_image !== '') {
        // If it's a relative path, make it absolute with backend URL
        if (product.primary_image.startsWith('/storage/')) {
          const absoluteUrl = `http://127.0.0.1:8000${product.primary_image}`
          console.log('ProductDetail converting to absolute URL:', absoluteUrl)
          return absoluteUrl
        }
        console.log('ProductDetail using direct URL:', product.primary_image)
        return product.primary_image
      }
      
      const fallbackUrl = `https://dummyimage.com/600x600/4f46e5/ffffff&text=${encodeURIComponent(product?.name || 'Product')}`
      console.log('ProductDetail using fallback URL:', fallbackUrl)
      return fallbackUrl
    },
    handleImageError(event) {
      const fallbackUrl = `https://dummyimage.com/600x600/4f46e5/ffffff&text=${encodeURIComponent(this.product.name)}`
      if (!event.target.src.includes('dummyimage.com')) {
        event.target.src = fallbackUrl
      }
    },
    async addToCart() {
      try {
        await this.cartStore.addItem(this.product.id)
        // Show success message
      } catch (error) {
        console.error('Error adding to cart:', error)
      }
    }
  }
}
</script>