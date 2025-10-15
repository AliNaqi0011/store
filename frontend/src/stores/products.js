import { defineStore } from 'pinia'
import apiClient from '../config/api'

export const useProductStore = defineStore('products', {
  state: () => ({
    products: [],
    currentProduct: null,
    categories: [],
    filters: {
      category: '',
      brand: '',
      price_min: '',
      price_max: '',
      search: '',
      sort: 'created_at'
    },
    loading: false
  }),

  actions: {
    async fetchProducts(params = {}) {
      this.loading = true
      try {
        // Clean empty filters
        const cleanFilters = Object.fromEntries(
          Object.entries(this.filters).filter(([key, value]) => value !== '' && value !== null)
        )
        const allParams = { ...cleanFilters, ...params }
        const response = await apiClient.get('/products', { params: allParams })
        
        // Handle paginated response structure
        if (response.data.data && Array.isArray(response.data.data)) {
          this.products = response.data.data
        } else if (Array.isArray(response.data)) {
          this.products = response.data
        } else {
          this.products = []
        }
        return response
      } catch (error) {
        this.products = []
        return { data: [] }
      } finally {
        this.loading = false
      }
    },

    async fetchProduct(slug) {
      try {
        const response = await apiClient.get(`/products/${slug}`)
        
        // Handle different response structures
        const productData = response.data.data || response.data
        
        this.currentProduct = productData
        return productData
      } catch (error) {
        throw error
      }
    },

    async fetchFeaturedProducts() {
      try {
        const response = await apiClient.get('/products/featured')
        return response.data.data || response.data || []
      } catch (error) {
        return []
      }
    },

    async fetchCategories() {
      try {
        const response = await apiClient.get('/categories')
        this.categories = response.data.data || response.data || []
        return this.categories
      } catch (error) {
        this.categories = []
        return []
      }
    },

    setFilter(key, value) {
      this.filters[key] = value
    },

    clearFilters() {
      this.filters = {
        category: '',
        brand: '',
        price_min: '',
        price_max: '',
        search: '',
        sort: 'created_at'
      }
    }
  }
})