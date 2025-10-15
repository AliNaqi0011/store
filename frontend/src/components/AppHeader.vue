<template>
  <header class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
    <!-- Top Bar -->
    <div class="bg-gray-900 text-white text-sm hidden md:block">
      <div class="max-w-7xl mx-auto px-4 py-2 flex justify-between items-center">
        <div class="flex items-center space-x-6">
          <span class="hidden lg:inline"><i class="fas fa-truck mr-2"></i>Free shipping on orders over $100</span>
          <span><i class="fas fa-phone mr-2"></i>24/7 Support</span>
        </div>
        <div class="flex items-center space-x-4">
          <a href="#" class="hover:text-gray-300"><i class="fab fa-facebook"></i></a>
          <a href="#" class="hover:text-gray-300"><i class="fab fa-twitter"></i></a>
          <a href="#" class="hover:text-gray-300"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
    </div>

    <!-- Main Header -->
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex items-center justify-between h-16">
        <!-- Mobile Menu Button -->
        <button @click="showMobileMenu = !showMobileMenu" class="md:hidden p-2 text-gray-600">
          <i class="fas fa-bars text-xl"></i>
        </button>
        
        <!-- Logo -->
        <router-link to="/" class="flex items-center space-x-2">
          <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg flex items-center justify-center" 
               :style="`background: linear-gradient(to right, ${settingsStore.settings.primary_color}, ${settingsStore.settings.secondary_color})`">
            <i class="fas fa-shopping-bag text-white text-sm md:text-lg"></i>
          </div>
          <span class="text-lg md:text-2xl font-bold bg-clip-text text-transparent" 
                :style="`background: linear-gradient(to right, ${settingsStore.settings.primary_color}, ${settingsStore.settings.secondary_color}); -webkit-background-clip: text;`">
            {{ settingsStore.settings.site_name }}
          </span>
        </router-link>

        <!-- Search Bar - Hidden on mobile -->
        <div class="hidden md:flex flex-1 max-w-2xl mx-8">
          <div class="relative w-full">
            <input 
              v-model="searchQuery"
              @keyup.enter="search"
              type="text" 
              placeholder="Search for products, brands, and more..."
              class="w-full pl-12 pr-20 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors"
            >
            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <button @click="search" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white px-4 py-1.5 rounded-lg hover:bg-blue-700 transition-colors">
              Search
            </button>
          </div>
        </div>

        <!-- Right Actions -->
        <div class="flex items-center space-x-2 md:space-x-6">
          <!-- Mobile Search Button -->
          <button @click="showMobileSearch = !showMobileSearch" class="md:hidden p-2 text-gray-600 hover:text-blue-600 transition-colors">
            <i class="fas fa-search text-lg"></i>
          </button>
          
          <!-- Wishlist -->
          <button class="relative p-2 text-gray-600 hover:text-blue-600 transition-colors">
            <i class="fas fa-heart text-lg md:text-xl"></i>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 md:w-5 md:h-5 flex items-center justify-center text-xs">3</span>
          </button>

          <!-- Cart -->
          <button @click="cartStore.toggleCart()" class="relative p-2 text-gray-600 hover:text-blue-600 transition-colors">
            <i class="fas fa-shopping-cart text-lg md:text-xl"></i>
            <span v-if="cartStore.count" class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs rounded-full w-4 h-4 md:w-5 md:h-5 flex items-center justify-center animate-bounce-subtle">
              {{ cartStore.count }}
            </span>
          </button>

          <!-- User Menu -->
          <div v-if="authStore.isAuthenticated" class="relative" ref="userMenu">
            <button @click="showUserMenu = !showUserMenu" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors">
              <div class="w-6 h-6 md:w-8 md:h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                <span class="text-white text-xs md:text-sm font-semibold">{{ authStore.user?.name?.charAt(0) }}</span>
              </div>
              <span class="hidden md:inline font-medium">{{ authStore.user?.name }}</span>
              <i class="fas fa-chevron-down text-xs hidden md:inline"></i>
            </button>
            
            <div v-if="showUserMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-2 animate-slide-up">
              <router-link to="/dashboard" class="block px-4 py-2 text-gray-700 hover:bg-gray-50"><i class="fas fa-user mr-3"></i>Dashboard</router-link>
              <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50"><i class="fas fa-box mr-3"></i>Orders</a>
              <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50"><i class="fas fa-heart mr-3"></i>Wishlist</a>
              <hr class="my-2">
              <button @click="logout" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50"><i class="fas fa-sign-out-alt mr-3"></i>Logout</button>
            </div>
          </div>
          
          <div v-else class="flex items-center space-x-2 md:space-x-3">
            <router-link to="/login" class="px-2 md:px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition-colors text-sm md:text-base">
              <span class="hidden md:inline">Sign In</span>
              <i class="fas fa-sign-in-alt md:hidden"></i>
            </router-link>
            <router-link to="/register" class="px-3 md:px-6 py-2 text-white rounded-lg font-medium transition-all transform hover:scale-105 text-sm md:text-base"
                         :style="`background: linear-gradient(to right, ${settingsStore.settings.primary_color}, ${settingsStore.settings.secondary_color})`">
              <span class="hidden md:inline">Sign Up</span>
              <i class="fas fa-user-plus md:hidden"></i>
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile Search Bar -->
    <div v-if="showMobileSearch" class="md:hidden border-t border-gray-200 bg-white p-4">
      <div class="relative">
        <input 
          v-model="searchQuery"
          @keyup.enter="search"
          type="text" 
          placeholder="Search products..."
          class="w-full pl-10 pr-16 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors"
        >
        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        <button @click="search" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition-colors text-sm">
          Go
        </button>
      </div>
    </div>

    <!-- Navigation -->
    <nav class="border-t border-gray-200 bg-gray-50 hidden md:block">
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center space-x-8 h-12">
          <router-link to="/categories" class="flex items-center space-x-1 text-gray-700 hover:text-blue-600 font-medium transition-colors">
            <i class="fas fa-th-large"></i>
            <span>All Categories</span>
          </router-link>
          <router-link to="/deals" class="flex items-center space-x-1 text-red-600 hover:text-red-700 font-medium transition-colors">
            <i class="fas fa-fire"></i>
            <span>Deals</span>
          </router-link>
          <router-link to="/products?category=electronics" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Electronics</router-link>
          <router-link to="/products?category=clothing" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Fashion</router-link>
          <router-link to="/products?category=home-garden" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Home & Garden</router-link>
          <div class="ml-auto flex items-center space-x-4">
            <span class="text-sm text-gray-500">Need help?</span>
            <router-link to="/contact" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Contact Support</router-link>
          </div>
        </div>
      </div>
    </nav>

    <!-- Mobile Menu -->
    <div v-if="showMobileMenu" class="md:hidden border-t border-gray-200 bg-white">
      <div class="px-4 py-4 space-y-3">
        <router-link to="/categories" class="flex items-center space-x-3 py-2 text-gray-700 hover:text-blue-600 font-medium transition-colors">
          <i class="fas fa-th-large w-5"></i>
          <span>All Categories</span>
        </router-link>
        <router-link to="/deals" class="flex items-center space-x-3 py-2 text-red-600 hover:text-red-700 font-medium transition-colors">
          <i class="fas fa-fire w-5"></i>
          <span>Deals</span>
        </router-link>
        <router-link to="/products?category=electronics" class="flex items-center space-x-3 py-2 text-gray-700 hover:text-blue-600 font-medium transition-colors">
          <i class="fas fa-laptop w-5"></i>
          <span>Electronics</span>
        </router-link>
        <router-link to="/products?category=clothing" class="flex items-center space-x-3 py-2 text-gray-700 hover:text-blue-600 font-medium transition-colors">
          <i class="fas fa-tshirt w-5"></i>
          <span>Fashion</span>
        </router-link>
        <router-link to="/products?category=home-garden" class="flex items-center space-x-3 py-2 text-gray-700 hover:text-blue-600 font-medium transition-colors">
          <i class="fas fa-home w-5"></i>
          <span>Home & Garden</span>
        </router-link>
        <hr class="my-3">
        <router-link to="/contact" class="flex items-center space-x-3 py-2 text-blue-600 hover:text-blue-700 font-medium transition-colors">
          <i class="fas fa-headset w-5"></i>
          <span>Contact Support</span>
        </router-link>
      </div>
    </div>
  </header>
</template>

<script>
import { useAuthStore } from '../stores/auth'
import { useCartStore } from '../stores/cart'
import { useProductStore } from '../stores/products'
import { useSettingsStore } from '../stores/settings'

export default {
  name: 'AppHeader',
  data() {
    return {
      searchQuery: '',
      showUserMenu: false,
      showMobileMenu: false,
      showMobileSearch: false
    }
  },
  setup() {
    const authStore = useAuthStore()
    const cartStore = useCartStore()
    const productStore = useProductStore()
    const settingsStore = useSettingsStore()
    
    return { authStore, cartStore, productStore, settingsStore }
  },
  mounted() {
    document.addEventListener('click', this.handleClickOutside)
  },
  beforeUnmount() {
    document.removeEventListener('click', this.handleClickOutside)
  },
  methods: {
    async logout() {
      await this.authStore.logout()
      this.showUserMenu = false
      this.$router.push('/')
    },
    search() {
      if (this.searchQuery.trim()) {
        this.$router.push({ name: 'SearchResults', query: { q: this.searchQuery } })
      }
    },
    handleClickOutside(event) {
      if (this.$refs.userMenu && !this.$refs.userMenu.contains(event.target)) {
        this.showUserMenu = false
      }
      // Close mobile menus when clicking outside
      if (!event.target.closest('.mobile-menu-trigger')) {
        this.showMobileMenu = false
        this.showMobileSearch = false
      }
    }
  }
}
</script>