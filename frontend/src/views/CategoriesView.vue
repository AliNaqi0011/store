<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-8">
      <!-- Header -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Shop by Category</h1>
        <p class="text-xl text-gray-600">Discover our wide range of product categories</p>
      </div>

      <!-- Categories Grid -->
      <LoadingSpinner v-if="loading" text="Loading categories..." />
      
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        <div v-for="category in categories" :key="category.id" 
             class="group cursor-pointer" @click="goToCategory(category.slug)">
          <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <!-- Category Image -->
            <div class="h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
              <i :class="getCategoryIcon(category.name)" class="text-6xl text-white"></i>
            </div>
            
            <!-- Category Info -->
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                {{ category.name }}
              </h3>
              <p class="text-gray-600 mb-4">{{ category.description }}</p>
              
              <!-- Product Count -->
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">{{ category.products_count || 0 }} products</span>
                <div class="flex items-center text-blue-600 group-hover:text-blue-700">
                  <span class="text-sm font-medium mr-1">Shop Now</span>
                  <i class="fas fa-arrow-right text-sm transform group-hover:translate-x-1 transition-transform"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-if="!loading && categories.length === 0" class="text-center py-16">
        <i class="fas fa-folder-open text-6xl text-gray-400 mb-6"></i>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">No Categories Available</h3>
        <p class="text-gray-600 mb-8">Categories will appear here once they are added by the admin.</p>
        <router-link to="/products" 
                     class="px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
          Browse All Products
        </router-link>
      </div>

      <!-- Featured Categories -->
      <div v-if="featuredCategories.length > 0" class="mt-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Featured Categories</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div v-for="category in featuredCategories" :key="'featured-' + category.id"
               class="relative h-64 rounded-2xl overflow-hidden cursor-pointer group"
               @click="goToCategory(category.slug)">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 opacity-90"></div>
            <div class="absolute inset-0 flex items-center justify-center text-center p-8">
              <div>
                <i :class="getCategoryIcon(category.name)" class="text-5xl text-white mb-4"></i>
                <h3 class="text-2xl font-bold text-white mb-2">{{ category.name }}</h3>
                <p class="text-blue-100 mb-4">{{ category.description }}</p>
                <span class="inline-flex items-center text-white font-medium group-hover:text-blue-200 transition-colors">
                  Explore Collection
                  <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import LoadingSpinner from '../components/LoadingSpinner.vue'
import apiClient from '../config/api'

export default {
  name: 'CategoriesView',
  components: {
    LoadingSpinner
  },
  data() {
    return {
      categories: [],
      featuredCategories: [],
      loading: true
    }
  },
  async created() {
    await this.fetchCategories()
  },
  methods: {
    async fetchCategories() {
      try {
        this.loading = true
        const response = await apiClient.get('/categories')
        this.categories = response.data
        
        // Set featured categories (first 2)
        this.featuredCategories = this.categories.slice(0, 2)
      } catch (error) {
        console.error('Error fetching categories:', error)
      } finally {
        this.loading = false
      }
    },
    goToCategory(slug) {
      this.$router.push(`/products?category=${slug}`)
    },
    getCategoryIcon(categoryName) {
      const icons = {
        'Electronics': 'fas fa-laptop',
        'Clothing': 'fas fa-tshirt',
        'Fashion': 'fas fa-tshirt',
        'Home & Garden': 'fas fa-home',
        'Sports': 'fas fa-dumbbell',
        'Books': 'fas fa-book',
        'Toys': 'fas fa-gamepad',
        'Beauty': 'fas fa-spa',
        'Automotive': 'fas fa-car',
        'Health': 'fas fa-heartbeat'
      }
      return icons[categoryName] || 'fas fa-tag'
    }
  }
}
</script>