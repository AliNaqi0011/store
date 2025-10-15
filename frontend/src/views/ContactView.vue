<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 text-white">
      <div class="absolute inset-0 bg-black opacity-20"></div>
      <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-72 h-72 bg-white opacity-10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-300 opacity-10 rounded-full blur-3xl animate-pulse delay-1000"></div>
      </div>
      
      <div class="relative max-w-7xl mx-auto px-4 py-24 text-center">
        <div class="animate-fade-in-up">
          <h1 class="text-5xl md:text-6xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-white to-blue-100">
            Get In Touch
          </h1>
          <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto leading-relaxed">
            Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
          </p>
          <div class="flex items-center justify-center space-x-8 text-blue-100">
            <div class="flex items-center space-x-2">
              <i class="fas fa-clock text-2xl"></i>
              <span class="text-lg">24/7 Support</span>
            </div>
            <div class="flex items-center space-x-2">
              <i class="fas fa-reply text-2xl"></i>
              <span class="text-lg">Quick Response</span>
            </div>
            <div class="flex items-center space-x-2">
              <i class="fas fa-shield-alt text-2xl"></i>
              <span class="text-lg">Secure</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-16">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Contact Form -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 border border-gray-100 hover:shadow-3xl transition-all duration-500 transform hover:-translate-y-1">
            <div class="text-center mb-8">
              <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full mb-4">
                <i class="fas fa-paper-plane text-white text-2xl"></i>
              </div>
              <h2 class="text-3xl font-bold text-gray-900 mb-2">Send us a Message</h2>
              <p class="text-gray-600">Fill out the form below and we'll get back to you within 24 hours</p>
            </div>
            
            <form @submit.prevent="submitForm" class="space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="group">
                  <label class="block text-sm font-semibold text-gray-700 mb-3 group-focus-within:text-blue-600 transition-colors">
                    <i class="fas fa-user mr-2"></i>First Name *
                  </label>
                  <input v-model="form.firstName" type="text" required 
                         class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-0 focus:border-blue-500 transition-all duration-300 hover:border-gray-300 bg-gray-50 focus:bg-white">
                </div>
                <div class="group">
                  <label class="block text-sm font-semibold text-gray-700 mb-3 group-focus-within:text-blue-600 transition-colors">
                    <i class="fas fa-user mr-2"></i>Last Name *
                  </label>
                  <input v-model="form.lastName" type="text" required 
                         class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-0 focus:border-blue-500 transition-all duration-300 hover:border-gray-300 bg-gray-50 focus:bg-white">
                </div>
              </div>
              
              <div class="group">
                <label class="block text-sm font-semibold text-gray-700 mb-3 group-focus-within:text-blue-600 transition-colors">
                  <i class="fas fa-envelope mr-2"></i>Email Address *
                </label>
                <input v-model="form.email" type="email" required 
                       class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-0 focus:border-blue-500 transition-all duration-300 hover:border-gray-300 bg-gray-50 focus:bg-white">
              </div>
              
              <div class="group">
                <label class="block text-sm font-semibold text-gray-700 mb-3 group-focus-within:text-blue-600 transition-colors">
                  <i class="fas fa-tag mr-2"></i>Subject *
                </label>
                <select v-model="form.subject" required 
                        class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-0 focus:border-blue-500 transition-all duration-300 hover:border-gray-300 bg-gray-50 focus:bg-white">
                  <option value="">Select a subject</option>
                  <option value="general">💬 General Inquiry</option>
                  <option value="order">📦 Order Support</option>
                  <option value="product">🛍️ Product Question</option>
                  <option value="return">↩️ Return/Exchange</option>
                  <option value="technical">🔧 Technical Support</option>
                  <option value="partnership">🤝 Partnership</option>
                  <option value="feedback">⭐ Feedback</option>
                </select>
              </div>
              
              <div class="group">
                <label class="block text-sm font-semibold text-gray-700 mb-3 group-focus-within:text-blue-600 transition-colors">
                  <i class="fas fa-comment-alt mr-2"></i>Message *
                </label>
                <textarea v-model="form.message" required rows="6" 
                          class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-0 focus:border-blue-500 transition-all duration-300 hover:border-gray-300 bg-gray-50 focus:bg-white resize-none" 
                          placeholder="Please describe how we can help you..."></textarea>
                <div class="text-right mt-2">
                  <span class="text-sm text-gray-500">{{ form.message.length }}/500</span>
                </div>
              </div>
              
              <button type="submit" :disabled="submitting || form.message.length > 500" 
                      class="w-full py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-bold text-lg hover:from-blue-700 hover:to-purple-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300 transform hover:scale-105 hover:shadow-xl flex items-center justify-center space-x-3">
                <i v-if="submitting" class="fas fa-spinner fa-spin"></i>
                <i v-else class="fas fa-paper-plane"></i>
                <span>{{ submitting ? 'Sending Message...' : 'Send Message' }}</span>
              </button>
              
              <p class="text-center text-sm text-gray-500 mt-4">
                <i class="fas fa-shield-alt mr-1"></i>
                Your information is secure and will never be shared with third parties.
              </p>
            </form>
          </div>
        </div>

        <!-- Contact Information -->
        <div class="space-y-8">
          <!-- Contact Cards -->
          <div class="space-y-6">
            <!-- Address Card -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border border-blue-200 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
              <div class="flex items-start space-x-4">
                <div class="w-14 h-14 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl flex items-center justify-center shadow-lg">
                  <i class="fas fa-map-marker-alt text-white text-xl"></i>
                </div>
                <div>
                  <h3 class="font-bold text-gray-900 text-lg mb-2">Visit Our Office</h3>
                  <p class="text-gray-700 leading-relaxed">123 Business Street<br>New York, NY 10001<br>United States</p>
                  <a href="#" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium mt-2 text-sm">
                    <i class="fas fa-directions mr-1"></i>Get Directions
                  </a>
                </div>
              </div>
            </div>
            
            <!-- Phone Card -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 border border-green-200 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
              <div class="flex items-start space-x-4">
                <div class="w-14 h-14 bg-gradient-to-r from-green-600 to-green-700 rounded-xl flex items-center justify-center shadow-lg">
                  <i class="fas fa-phone text-white text-xl"></i>
                </div>
                <div>
                  <h3 class="font-bold text-gray-900 text-lg mb-2">Call Us</h3>
                  <p class="text-gray-700 font-semibold text-lg">+1 (555) 123-4567</p>
                  <p class="text-sm text-gray-600 mt-1">Mon-Fri 9AM-6PM EST</p>
                  <a href="tel:+15551234567" class="inline-flex items-center text-green-600 hover:text-green-700 font-medium mt-2 text-sm">
                    <i class="fas fa-phone mr-1"></i>Call Now
                  </a>
                </div>
              </div>
            </div>
            
            <!-- Email Card -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 border border-purple-200 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
              <div class="flex items-start space-x-4">
                <div class="w-14 h-14 bg-gradient-to-r from-purple-600 to-purple-700 rounded-xl flex items-center justify-center shadow-lg">
                  <i class="fas fa-envelope text-white text-xl"></i>
                </div>
                <div>
                  <h3 class="font-bold text-gray-900 text-lg mb-2">Email Us</h3>
                  <p class="text-gray-700 font-semibold">support@nexshop.com</p>
                  <p class="text-sm text-gray-600 mt-1">Response within 24 hours</p>
                  <a href="mailto:support@nexshop.com" class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium mt-2 text-sm">
                    <i class="fas fa-envelope mr-1"></i>Send Email
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Business Hours -->
          <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <div class="text-center mb-6">
              <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-full mb-3">
                <i class="fas fa-clock text-white"></i>
              </div>
              <h3 class="text-2xl font-bold text-gray-900">Business Hours</h3>
            </div>
            <div class="space-y-4">
              <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-600 font-medium">Monday - Friday</span>
                <span class="font-bold text-gray-900">9:00 AM - 6:00 PM</span>
              </div>
              <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-600 font-medium">Saturday</span>
                <span class="font-bold text-gray-900">10:00 AM - 4:00 PM</span>
              </div>
              <div class="flex justify-between items-center py-2">
                <span class="text-gray-600 font-medium">Sunday</span>
                <span class="font-bold text-red-500">Closed</span>
              </div>
            </div>
            
            <!-- Live Chat -->
            <div class="mt-6 p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl border border-blue-200">
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                  <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                  <span class="font-semibold text-gray-900">Live Chat Available</span>
                </div>
                <button class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-medium hover:from-blue-700 hover:to-purple-700 transition-all">
                  <i class="fas fa-comments mr-2"></i>Chat Now
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
import { showNotification } from '../utils/errorHandler'

export default {
  name: 'ContactView',
  data() {
    return {
      form: {
        firstName: '',
        lastName: '',
        email: '',
        subject: '',
        message: ''
      },
      submitting: false
    }
  },
  methods: {
    async submitForm() {
      this.submitting = true
      try {
        const response = await fetch('http://127.0.0.1:8000/api/contact', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify(this.form)
        })
        
        const data = await response.json()
        
        if (response.ok) {
          showNotification(data.message, 'success')
          this.form = { firstName: '', lastName: '', email: '', subject: '', message: '' }
        } else {
          throw new Error(data.message || 'Failed to send message')
        }
      } catch (error) {
        console.error('Contact form error:', error)
        showNotification('Failed to send message. Please try again.', 'error')
      } finally {
        this.submitting = false
      }
    }
  }
}
</script>

<style scoped>
@keyframes fade-in-up {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in-up {
  animation: fade-in-up 1s ease-out;
}

.animate-bounce-subtle {
  animation: bounce-subtle 2s infinite;
}

@keyframes bounce-subtle {
  0%, 20%, 50%, 80%, 100% {
    transform: translateY(0);
  }
  40% {
    transform: translateY(-5px);
  }
  60% {
    transform: translateY(-3px);
  }
}

.hover\:shadow-3xl:hover {
  box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
}

/* Custom scrollbar for textarea */
textarea::-webkit-scrollbar {
  width: 6px;
}

textarea::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}

textarea::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 3px;
}

textarea::-webkit-scrollbar-thumb:hover {
  background: #a8a8a8;
}
</style>