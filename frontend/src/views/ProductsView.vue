<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-4 md:py-8">
      <!-- Search & Filters -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 md:p-6 mb-4 md:mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 md:gap-4">
          <div class="md:col-span-2">
            <input 
              v-model="filters.search" 
              @input="debouncedSearch"
              type="text" 
              placeholder="Search products..." 
              class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm md:text-base"
            >
          </div>
          <div>
            <select 
              v-model="filters.category" 
              @change="applyFilters"
              class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm md:text-base"
            >
              <option value="">All Categories</option>
              <option v-for="category in categories" :key="category.id" :value="category.slug">
                {{ category.name }}
              </option>
            </select>
          </div>
          <div>
            <select 
              v-model="filters.sort" 
              @change="applyFilters"
              class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm md:text-base"
            >
              <option value="created_at">Newest</option>
              <option value="price_low">Price: Low to High</option>
              <option value="price_high">Price: High to Low</option>
              <option value="name">Name A-Z</option>
              <option value="rating">Highest Rated</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Products Grid -->
      <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
        <LoadingSkeleton v-for="n in 8" :key="n" type="product-card" />
      </div>
      
      <div v-else-if="products.length > 0">
        <div class="flex justify-between items-center mb-4 md:mb-6">
          <p class="text-gray-600 text-sm md:text-base">{{ products.length }} products found</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
          <ProductCard 
            v-for="product in products" 
            :key="product.id" 
            :product="product"
            @added-to-cart="onAddedToCart"
          />
        </div>
      </div>
      
      <div v-else class="text-center py-8 md:py-16">
        <div class="text-gray-500">
          <i class="fas fa-search text-2xl md:text-4xl mb-2 md:mb-4"></i>
          <h3 class="text-base md:text-lg font-semibold mb-1 md:mb-2">No products found</h3>
          <p class="text-sm md:text-base">Try adjusting your search or filters</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ProductCard from '../components/ProductCard.vue'
import LoadingSkeleton from '../components/LoadingSkeleton.vue'
import { useProductStore } from '../stores/products'
import { showNotification } from '../utils/errorHandler'

export default {
  name: 'ProductsView',
  components: {
    ProductCard,
    LoadingSkeleton
  },
  data() {
    return {
      products: [],
      categories: [],
      loading: true,
      filters: {
        search: '',
        category: '',
        sort: 'created_at'
      }
    }
  },
  setup() {
    const productStore = useProductStore()
    return { productStore }
  },
  async created() {
    await this.loadData()
  },
  methods: {
    async loadData() {
      this.loading = true
      try {
        const [productsResponse, categoriesResponse] = await Promise.all([
          this.productStore.fetchProducts(this.filters),
          this.productStore.fetchCategories()
        ])
        
        this.products = productsResponse.data?.data || []
        this.categories = categoriesResponse
      } catch (error) {
        showNotification('Failed to load products', 'error')
      } finally {
        this.loading = false
      }
    },
    
    debouncedSearch: debounce(function() {
      this.applyFilters()
    }, 500),
    
    async applyFilters() {
      this.loading = true
      try {
        const response = await this.productStore.fetchProducts(this.filters)
        this.products = response.data?.data || []
      } catch (error) {
        showNotification('Failed to filter products', 'error')
      } finally {
        this.loading = false
      }
    },
    
    onAddedToCart(product) {
      showNotification(`${product.name} added to cart!`, 'success')
    }
  }
}

function debounce(func, wait) {
  let timeout
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout)
      func(...args)
    }
    clearTimeout(timeout)
    timeout = setTimeout(later, wait)
  }
}
</script>