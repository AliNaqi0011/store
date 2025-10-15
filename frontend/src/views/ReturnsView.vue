<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
      <div class="max-w-4xl mx-auto px-4 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-white bg-opacity-20 rounded-full mb-6">
          <i class="fas fa-undo-alt text-3xl"></i>
        </div>
        <h1 class="text-5xl font-bold mb-4">Returns & Exchanges</h1>
        <p class="text-xl text-blue-100">Hassle-free returns within 30 days. Your satisfaction is our priority.</p>
      </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-16">
      <!-- Quick Stats -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        <div class="text-center p-6 bg-white rounded-2xl shadow-lg">
          <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-calendar-alt text-green-600 text-2xl"></i>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-2">30 Days</h3>
          <p class="text-gray-600">Return window</p>
        </div>
        <div class="text-center p-6 bg-white rounded-2xl shadow-lg">
          <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-shipping-fast text-blue-600 text-2xl"></i>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-2">Free</h3>
          <p class="text-gray-600">Return shipping</p>
        </div>
        <div class="text-center p-6 bg-white rounded-2xl shadow-lg">
          <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-clock text-purple-600 text-2xl"></i>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-2">3-5 Days</h3>
          <p class="text-gray-600">Refund processing</p>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Return Policy -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
          <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4">
              <i class="fas fa-undo text-white text-xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Return Policy</h2>
          </div>
          
          <div class="space-y-8">
            <div class="border-l-4 border-green-500 pl-6">
              <h3 class="text-xl font-bold text-gray-900 mb-3">30-Day Return Window</h3>
              <p class="text-gray-600">You have 30 days from delivery to return items. No questions asked!</p>
            </div>
            
            <div class="border-l-4 border-blue-500 pl-6">
              <h3 class="text-xl font-bold text-gray-900 mb-3">Condition Requirements</h3>
              <ul class="space-y-2 text-gray-600">
                <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Unused and in original condition</li>
                <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Original packaging included</li>
                <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>All tags and labels attached</li>
              </ul>
            </div>
            
            <div class="border-l-4 border-purple-500 pl-6">
              <h3 class="text-xl font-bold text-gray-900 mb-3">Non-Returnable Items</h3>
              <ul class="space-y-2 text-gray-600">
                <li class="flex items-center"><i class="fas fa-times text-red-500 mr-3"></i>Personalized items</li>
                <li class="flex items-center"><i class="fas fa-times text-red-500 mr-3"></i>Perishable goods</li>
                <li class="flex items-center"><i class="fas fa-times text-red-500 mr-3"></i>Digital downloads</li>
              </ul>
            </div>
          </div>
        </div>

        <!-- How to Return -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
          <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4">
              <i class="fas fa-list-ol text-white text-xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">How to Return</h2>
          </div>
          
          <div class="space-y-6">
            <div class="flex items-start space-x-4">
              <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">1</div>
              <div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Start Your Return</h3>
                <p class="text-gray-600">Contact our support team or use our online return portal to initiate your return.</p>
              </div>
            </div>
            
            <div class="flex items-start space-x-4">
              <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">2</div>
              <div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Get Return Label</h3>
                <p class="text-gray-600">We'll email you a prepaid return shipping label within 24 hours.</p>
              </div>
            </div>
            
            <div class="flex items-start space-x-4">
              <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">3</div>
              <div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Pack & Ship</h3>
                <p class="text-gray-600">Pack items securely in original packaging and attach the return label.</p>
              </div>
            </div>
            
            <div class="flex items-start space-x-4">
              <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">4</div>
              <div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Get Refunded</h3>
                <p class="text-gray-600">Receive your refund within 3-5 business days after we process your return.</p>
              </div>
            </div>
          </div>
          
          <div class="mt-8 p-6 bg-gradient-to-r from-green-50 to-blue-50 rounded-2xl border border-green-200">
            <div class="flex items-center mb-3">
              <i class="fas fa-exchange-alt text-green-600 text-xl mr-3"></i>
              <h3 class="text-lg font-bold text-gray-900">Need an Exchange?</h3>
            </div>
            <p class="text-gray-600 mb-4">Want a different size or color? We make exchanges easy!</p>
            <button class="bg-gradient-to-r from-green-500 to-blue-500 text-white px-6 py-3 rounded-xl font-semibold hover:from-green-600 hover:to-blue-600 transition-all">
              Start Exchange
            </button>
          </div>
        </div>
      </div>
      
      <!-- Contact Support -->
      <div class="mt-16 text-center">
        <div class="bg-white rounded-3xl shadow-xl p-12">
          <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-headset text-white text-3xl"></i>
          </div>
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Need Help?</h2>
          <p class="text-xl text-gray-600 mb-8">Our customer service team is here to help with your return</p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <router-link to="/contact" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-xl font-bold hover:from-blue-700 hover:to-purple-700 transition-all">
              <i class="fas fa-envelope mr-2"></i>Contact Support
            </router-link>
            <a href="tel:+15551234567" class="bg-white border-2 border-gray-300 text-gray-700 px-8 py-4 rounded-xl font-bold hover:border-gray-400 transition-all">
              <i class="fas fa-phone mr-2"></i>Call Us
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ReturnsView'
}
</script>