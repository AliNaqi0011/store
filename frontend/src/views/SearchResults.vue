<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-8">
      <!-- Search Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
          Search Results
          <span v-if="searchQuery" class="text-blue-600">"{{ searchQuery }}"</span>
        </h1>
        <p class="text-gray-600">{{ totalResults }} products found</p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Filters Sidebar -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-4">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Filters</h3>
            
            <!-- Price Range -->
            <div class="mb-6">
              <h4 class="font-semibold text-gray-900 mb-3">Price Range</h4>
              <div class="space-y-3">
                <div class="flex items-center space-x-3">
                  <input v-model="filters.priceMin" type="number" placeholder="Min" 
                         class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                  <span class="text-gray-500">-</span>
                  <input v-model="filters.priceMax" type="number" placeholder="Max"
                         class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
              </div>
            </div>

            <!-- Categories -->
            <div class="mb-6">
              <h4 class="font-semibold text-gray-900 mb-3">Categories</h4>
              <div class="space-y-2">
                <label v-for="category in categories" :key="category.id" class="flex items-center">
                  <input v-model="filters.categories" :value="category.id" type="checkbox"
                         class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                  <span class="ml-2 text-sm text-gray-700">{{ category.name }}</span>
                </label>
              </div>
            </div>

            <!-- Rating -->
            <div class="mb-6">
              <h4 class="font-semibold text-gray-900 mb-3">Rating</h4>
              <div class="space-y-2">
                <label v-for="rating in [5,4,3,2,1]" :key="rating" class="flex items-center">
                  <input v-model="filters.rating" :value="rating" type="radio" name="rating"
                         class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                  <div class="ml-2 flex items-center">
                    <div class="flex text-yellow-400">
                      <i v-for="n in rating" :key="n" class="fas fa-star text-sm"></i>
                      <i v-for="n in (5-rating)" :key="n" class="far fa-star text-sm"></i>
                    </div>
                    <span class="ml-1 text-sm text-gray-600">& up</span>
                  </div>
                </label>
              </div>
            </div>

            <button @click="applyFilters" 
                    class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
              Apply Filters
            </button>
          </div>
        </div>

        <!-- Results -->
        <div class="lg:col-span-3">
          <!-- Sort Options -->
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
              <span class="text-sm text-gray-600">Sort by:</span>
              <select v-model="sortBy" @change="applySort"
                      class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="relevance">Relevance</option>
                <option value="price_low">Price: Low to High</option>
                <option value="price_high">Price: High to Low</option>
                <option value="rating">Customer Rating</option>
                <option value="newest">Newest First</option>
              </select>
            </div>
            
            <div class="flex items-center space-x-2">
              <button @click="viewMode = 'grid'" 
                      :class="viewMode === 'grid' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600'"
                      class="p-2 rounded-lg transition-colors">
                <i class="fas fa-th-large"></i>
              </button>
              <button @click="viewMode = 'list'" 
                      :class="viewMode === 'list' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600'"
                      class="p-2 rounded-lg transition-colors">
                <i class="fas fa-list"></i>
              </button>
            </div>
          </div>

          <!-- Products Grid -->
          <LoadingSpinner v-if="loading" text="Searching products..." />
          
          <div v-else-if="products.length === 0" class="text-center py-16">
            <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No products found</h3>
            <p class="text-gray-600 mb-6">Try adjusting your search terms or filters</p>
            <button @click="clearFilters" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
              Clear Filters
            </button>
          </div>

          <div v-else>
            <!-- Grid View -->
            <div v-if="viewMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <ProductCard v-for="product in products" :key="product.id" :product="product" />
            </div>

            <!-- List View -->
            <div v-else class="space-y-4">
              <div v-for="product in products" :key="product.id" 
                   class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex items-center space-x-6">
                <img :src="product.image" :alt="product.name" class="w-24 h-24 object-cover rounded-lg">
                <div class="flex-1">
                  <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ product.name }}</h3>
                  <p class="text-gray-600 mb-2">{{ product.short_description }}</p>
                  <div class="flex items-center space-x-4">
                    <span class="text-2xl font-bold text-blue-600">${{ product.price }}</span>
                    <div class="flex items-center">
                      <div class="flex text-yellow-400 mr-2">
                        <i v-for="n in 5" :key="n" class="fas fa-star text-sm"></i>
                      </div>
                      <span class="text-sm text-gray-500">({{ product.reviews_count || 0 }})</span>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col space-y-2">
                  <button class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    Add to Cart
                  </button>
                  <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-heart"></i>
                  </button>
                </div>
              </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
              <div class="flex items-center space-x-2">
                <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                  Previous
                </button>
                <button v-for="page in [1,2,3,4,5]" :key="page"
                        :class="page === 1 ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                        class="px-3 py-2 border border-gray-300 rounded-lg transition-colors">
                  {{ page }}
                </button>
                <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                  Next
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ProductCard from '../components/ProductCard.vue'
import LoadingSpinner from '../components/LoadingSpinner.vue'

export default {
  name: 'SearchResults',
  components: {
    ProductCard,
    LoadingSpinner
  },
  data() {
    return {
      searchQuery: '',
      products: [],
      categories: [],
      totalResults: 0,
      loading: false,
      viewMode: 'grid',
      sortBy: 'relevance',
      filters: {
        priceMin: '',
        priceMax: '',
        categories: [],
        rating: null
      }
    }
  },
  created() {
    this.searchQuery = this.$route.query.q || ''
    this.loadResults()
  },
  methods: {
    async loadResults() {
      this.loading = true
      // Simulate API call
      setTimeout(() => {
        this.products = []
        this.totalResults = 0
        this.loading = false
      }, 1000)
    },
    applyFilters() {
      this.loadResults()
    },
    applySort() {
      this.loadResults()
    },
    clearFilters() {
      this.filters = {
        priceMin: '',
        priceMax: '',
        categories: [],
        rating: null
      }
      this.loadResults()
    }
  }
}
</script>