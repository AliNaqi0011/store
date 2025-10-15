import { defineStore } from 'pinia'
import apiClient from '../config/api'

export const useCartStore = defineStore('cart', {
  state: () => {
    let items = []
    try {
      const stored = localStorage.getItem('nexshop_cart')
      if (stored) {
        const data = JSON.parse(stored)
        items = data.items || []
      }
    } catch (error) {
      console.error('Failed to load cart from localStorage:', error)
      items = []
    }
    return {
      items,
      count: 0,
      total: 0,
      isOpen: false,
      loading: false,
      error: null
    }
  },

  actions: {
    loadFromLocalStorage() {
      try {
        const saved = localStorage.getItem('nexshop_cart')
        if (saved) {
          const data = JSON.parse(saved)
          this.items = data.items || []
          this.updateTotals()
        }
      } catch (error) {
        console.error('Failed to load cart from localStorage:', error)
        this.items = []
        this.count = 0
        this.total = 0
      }
    },

    saveToLocalStorage() {
      try {
        localStorage.setItem('nexshop_cart', JSON.stringify({
          items: this.items,
          count: this.count,
          total: this.total
        }))
      } catch (error) {
        console.error('Failed to save cart to localStorage:', error)
      }
    },

    async fetchCart() {
      this.loading = true
      this.error = null
      try {
        this.loadFromLocalStorage()
      } catch (error) {
        this.error = 'Failed to load cart'
      } finally {
        this.loading = false
      }
    },

    async addItem(productId, variantId = null, quantity = 1) {
      if (!productId || quantity <= 0) {
        throw new Error('Invalid product ID or quantity')
      }
      
      try {
        this.loading = true
        this.error = null
        
        // Get specific product details - use products list endpoint since individual product endpoint may not exist
        const response = await apiClient.get('/products')
        const products = response.data.data || response.data
        const product = products.find(p => p.id === productId)
        
        if (!product) {
          throw new Error('Product not found')
        }

        // Check if item already exists
        const existingIndex = this.items.findIndex(item => item.product_id === productId)
        
        if (existingIndex >= 0) {
          // Update quantity
          this.items[existingIndex].quantity += quantity
          this.items[existingIndex].total = this.items[existingIndex].price * this.items[existingIndex].quantity
        } else {
          // Add new item
          const cartItem = {
            id: crypto.randomUUID(),
            product_id: productId,
            variant_id: variantId,
            name: product.name,
            price: parseFloat(product.price),
            quantity: quantity,
            total: parseFloat(product.price) * quantity,
            image: product.primary_image ? `http://127.0.0.1:8000${product.primary_image}` : null,
            brand: product.brand || ''
          }
          this.items.push(cartItem)
        }
        
        this.updateTotals()
        this.saveToLocalStorage()
        
        return { message: 'Item added to cart' }
      } catch (error) {
        this.error = 'Failed to add item to cart'
        throw error
      } finally {
        this.loading = false
      }
    },

    updateTotals() {
      this.count = this.items.reduce((sum, item) => sum + item.quantity, 0)
      this.total = this.items.reduce((sum, item) => sum + item.total, 0)
    },

    async updateQuantity(itemId, quantity) {
      if (quantity <= 0) {
        return this.removeItem(itemId)
      }
      
      const item = this.items.find(i => i.id === itemId)
      if (item) {
        item.quantity = Math.max(1, Math.min(99, quantity))
        item.total = item.price * item.quantity
        this.updateTotals()
        this.saveToLocalStorage()
      }
    },

    async removeItem(itemId) {
      this.items = this.items.filter(i => i.id !== itemId)
      this.updateTotals()
      this.saveToLocalStorage()
    },

    clearCart() {
      this.items = []
      this.count = 0
      this.total = 0
      this.saveToLocalStorage()
    },

    toggleCart() {
      this.isOpen = !this.isOpen
    }
  }
})