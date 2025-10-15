<template>
  <footer class="bg-gray-900 text-white">
    <!-- Main Footer -->
    <div class="max-w-7xl mx-auto px-4 py-8 md:py-16">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 md:gap-8">
        <!-- Brand Section -->
        <div class="lg:col-span-2">
          <div class="flex items-center space-x-2 mb-4 md:mb-6">
            <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
              <i class="fas fa-shopping-bag text-white text-sm md:text-lg"></i>
            </div>
            <span class="text-xl md:text-2xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
              {{ settingsStore?.settings?.site_name || 'NexShop' }}
            </span>
          </div>
          <p class="text-gray-300 mb-4 md:mb-6 leading-relaxed text-sm md:text-base">
            Your premier destination for quality products at unbeatable prices. We're committed to providing exceptional shopping experiences with fast shipping and outstanding customer service.
          </p>
          
          <!-- Social Links -->
          <div class="flex space-x-3 md:space-x-4">
            <a href="#" class="w-8 h-8 md:w-10 md:h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition-colors">
              <i class="fab fa-facebook text-sm md:text-base"></i>
            </a>
            <a href="#" class="w-8 h-8 md:w-10 md:h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-400 transition-colors">
              <i class="fab fa-twitter text-sm md:text-base"></i>
            </a>
            <a href="#" class="w-8 h-8 md:w-10 md:h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-pink-600 transition-colors">
              <i class="fab fa-instagram text-sm md:text-base"></i>
            </a>
            <a href="#" class="w-8 h-8 md:w-10 md:h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
              <i class="fab fa-youtube text-sm md:text-base"></i>
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h3 class="text-base md:text-lg font-bold mb-4 md:mb-6">Quick Links</h3>
          <ul class="space-y-2 md:space-y-3">
            <li><router-link to="/" class="text-gray-300 hover:text-white transition-colors flex items-center text-sm md:text-base"><i class="fas fa-home w-4 mr-2 text-xs md:text-sm"></i>Home</router-link></li>
            <li><router-link to="/products" class="text-gray-300 hover:text-white transition-colors flex items-center text-sm md:text-base"><i class="fas fa-shopping-bag w-4 mr-2 text-xs md:text-sm"></i>Products</router-link></li>
            <li><router-link to="/deals" class="text-gray-300 hover:text-white transition-colors flex items-center text-sm md:text-base"><i class="fas fa-tags w-4 mr-2 text-xs md:text-sm"></i>Deals</router-link></li>
            <li><router-link to="/new-arrivals" class="text-gray-300 hover:text-white transition-colors flex items-center text-sm md:text-base"><i class="fas fa-star w-4 mr-2 text-xs md:text-sm"></i>New Arrivals</router-link></li>
            <li><a href="#" class="text-gray-300 hover:text-white transition-colors flex items-center text-sm md:text-base"><i class="fas fa-gift w-4 mr-2 text-xs md:text-sm"></i>Gift Cards</a></li>
          </ul>
        </div>

        <!-- Customer Service -->
        <div>
          <h3 class="text-base md:text-lg font-bold mb-4 md:mb-6">Customer Service</h3>
          <ul class="space-y-2 md:space-y-3">
            <li><router-link to="/contact" class="text-gray-300 hover:text-white transition-colors flex items-center text-sm md:text-base"><i class="fas fa-phone w-4 mr-2 text-xs md:text-sm"></i>Contact Us</router-link></li>
            <li><router-link to="/shipping" class="text-gray-300 hover:text-white transition-colors flex items-center text-sm md:text-base"><i class="fas fa-truck w-4 mr-2 text-xs md:text-sm"></i>Shipping Info</router-link></li>
            <li><router-link to="/returns" class="text-gray-300 hover:text-white transition-colors flex items-center text-sm md:text-base"><i class="fas fa-undo w-4 mr-2 text-xs md:text-sm"></i>Returns & Exchanges</router-link></li>
            <li><router-link to="/privacy" class="text-gray-300 hover:text-white transition-colors flex items-center text-sm md:text-base"><i class="fas fa-shield-alt w-4 mr-2 text-xs md:text-sm"></i>Privacy Policy</router-link></li>
            <li><router-link to="/terms" class="text-gray-300 hover:text-white transition-colors flex items-center text-sm md:text-base"><i class="fas fa-file-contract w-4 mr-2 text-xs md:text-sm"></i>Terms of Service</router-link></li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div>
          <h3 class="text-base md:text-lg font-bold mb-4 md:mb-6">Get in Touch</h3>
          <div class="space-y-3 md:space-y-4">
            <div class="flex items-start space-x-3">
              <i class="fas fa-map-marker-alt text-blue-400 mt-1 text-xs md:text-sm"></i>
              <div>
                <p class="text-gray-300 text-sm md:text-base">123 Commerce Street</p>
                <p class="text-gray-300 text-sm md:text-base">New York, NY 10001</p>
              </div>
            </div>
            <div class="flex items-center space-x-3">
              <i class="fas fa-phone text-blue-400 text-xs md:text-sm"></i>
              <p class="text-gray-300 text-sm md:text-base">+1 (555) 123-4567</p>
            </div>
            <div class="flex items-center space-x-3">
              <i class="fas fa-envelope text-blue-400 text-xs md:text-sm"></i>
              <p class="text-gray-300 text-sm md:text-base">support@nexshop.com</p>
            </div>
            <div class="flex items-center space-x-3">
              <i class="fas fa-clock text-blue-400 text-xs md:text-sm"></i>
              <p class="text-gray-300 text-sm md:text-base">24/7 Customer Support</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Newsletter -->
    <div class="border-t border-gray-800">
      <div class="max-w-7xl mx-auto px-4 py-6 md:py-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 md:gap-6">
          <div class="text-center md:text-left">
            <h3 class="text-lg md:text-xl font-bold mb-1 md:mb-2">Stay Updated</h3>
            <p class="text-gray-300 text-sm md:text-base">Subscribe to get special offers, free giveaways, and exclusive deals.</p>
          </div>
          <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <input type="email" placeholder="Enter your email address" 
                   class="px-3 md:px-4 py-2 md:py-3 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white placeholder-gray-400 w-full sm:min-w-64 md:min-w-80 text-sm md:text-base">
            <button class="px-4 md:px-6 py-2 md:py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all whitespace-nowrap text-sm md:text-base">
              Subscribe Now
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-gray-800 bg-gray-950">
      <div class="max-w-7xl mx-auto px-4 py-4 md:py-6">
        <div class="flex flex-col md:flex-row items-center justify-between gap-3 md:gap-4">
          <div class="flex flex-col sm:flex-row items-center gap-3 md:gap-6">
            <p class="text-gray-400 text-xs md:text-sm text-center">© 2024 NexShop. All rights reserved.</p>
            <div class="flex items-center space-x-2 md:space-x-4">
              <div class="h-4 md:h-6 w-8 md:w-10 bg-gray-300 rounded text-xs flex items-center justify-center opacity-70">VISA</div>
              <div class="h-4 md:h-6 w-8 md:w-10 bg-gray-300 rounded text-xs flex items-center justify-center opacity-70">MC</div>
              <div class="h-4 md:h-6 w-8 md:w-10 bg-gray-300 rounded text-xs flex items-center justify-center opacity-70">AMEX</div>
              <div class="h-4 md:h-6 w-8 md:w-10 bg-gray-300 rounded text-xs flex items-center justify-center opacity-70">PP</div>
            </div>
          </div>
          
          <div class="flex items-center space-x-3 md:space-x-6 text-xs md:text-sm text-gray-400">
            <router-link to="/privacy" class="hover:text-white transition-colors">Privacy</router-link>
            <router-link to="/terms" class="hover:text-white transition-colors">Terms</router-link>
            <router-link to="/returns" class="hover:text-white transition-colors">Returns</router-link>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
import { useSettingsStore } from '../stores/settings'

export default {
  name: 'AppFooter',
  setup() {
    const settingsStore = useSettingsStore()
    return { settingsStore }
  }
}
</script>