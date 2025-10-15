<template>
  <footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 py-16">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Company Info -->
        <div>
          <h3 class="text-xl font-bold mb-6">NexShop</h3>
          <p class="text-gray-300 mb-6 leading-relaxed">
            Your trusted online shopping destination for quality products, 
            exceptional service, and unbeatable prices.
          </p>
          <div class="flex space-x-4">
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition-colors">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-400 transition-colors">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-pink-600 transition-colors">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
              <i class="fab fa-youtube"></i>
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h3 class="text-lg font-semibold mb-6">Quick Links</h3>
          <ul class="space-y-3">
            <li><router-link to="/" class="text-gray-300 hover:text-white transition-colors">Home</router-link></li>
            <li><router-link to="/products" class="text-gray-300 hover:text-white transition-colors">Products</router-link></li>
            <li><router-link to="/categories" class="text-gray-300 hover:text-white transition-colors">Categories</router-link></li>
            <li><router-link to="/cart" class="text-gray-300 hover:text-white transition-colors">Shopping Cart</router-link></li>
            <li><router-link to="/orders" class="text-gray-300 hover:text-white transition-colors">My Orders</router-link></li>
          </ul>
        </div>

        <!-- Customer Service -->
        <div>
          <h3 class="text-lg font-semibold mb-6">Customer Service</h3>
          <ul class="space-y-3">
            <li><router-link to="/contact" class="text-gray-300 hover:text-white transition-colors">Contact Us</router-link></li>
            <li><router-link to="/shipping" class="text-gray-300 hover:text-white transition-colors">Shipping Info</router-link></li>
            <li><router-link to="/returns" class="text-gray-300 hover:text-white transition-colors">Returns & Exchanges</router-link></li>
            <li><a href="mailto:support@nexshop.com" class="text-gray-300 hover:text-white transition-colors">Email Support</a></li>
            <li><a href="tel:+15551234567" class="text-gray-300 hover:text-white transition-colors">Call Us: (555) 123-4567</a></li>
          </ul>
        </div>

        <!-- Legal -->
        <div>
          <h3 class="text-lg font-semibold mb-6">Legal</h3>
          <ul class="space-y-3">
            <li><router-link to="/privacy" class="text-gray-300 hover:text-white transition-colors">Privacy Policy</router-link></li>
            <li><router-link to="/terms" class="text-gray-300 hover:text-white transition-colors">Terms of Service</router-link></li>
            <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Cookie Policy</a></li>
            <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Accessibility</a></li>
            <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Sitemap</a></li>
          </ul>
        </div>
      </div>

      <!-- Newsletter Signup -->
      <div class="border-t border-gray-800 mt-12 pt-8">
        <div class="max-w-md mx-auto text-center">
          <h3 class="text-lg font-semibold mb-4">Stay Updated</h3>
          <p class="text-gray-300 mb-6">Subscribe to our newsletter for the latest deals and updates</p>
          <div class="flex">
            <input 
              type="email" 
              placeholder="Enter your email" 
              class="flex-1 px-4 py-3 bg-gray-800 border border-gray-700 rounded-l-lg focus:outline-none focus:border-blue-500 text-white"
            >
            <button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-r-lg font-semibold transition-colors">
              Subscribe
            </button>
          </div>
        </div>
      </div>

      <!-- Bottom Bar -->
      <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
        <div class="text-gray-300 text-sm mb-4 md:mb-0">
          © {{ currentYear }} NexShop. All rights reserved.
        </div>
        <div class="flex items-center space-x-6 text-sm text-gray-300">
          <div class="flex items-center space-x-2">
            <i class="fas fa-shield-alt text-green-500"></i>
            <span>Secure Shopping</span>
          </div>
          <div class="flex items-center space-x-2">
            <i class="fas fa-truck text-blue-500"></i>
            <span>Free Shipping</span>
          </div>
          <div class="flex items-center space-x-2">
            <i class="fas fa-undo text-purple-500"></i>
            <span>Easy Returns</span>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'FooterComponent',
  computed: {
    currentYear() {
      return new Date().getFullYear()
    }
  }
}
</script>