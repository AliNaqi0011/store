<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 py-16">
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Shipping Information</h1>
        <p class="text-xl text-gray-600">Everything you need to know about our shipping policies</p>
      </div>

      <div class="bg-white rounded-2xl shadow-lg p-8 space-y-8">
        <!-- Shipping Options -->
        <section>
          <h2 class="text-2xl font-bold text-gray-900 mb-6">Shipping Options</h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="border border-gray-200 rounded-xl p-6 text-center">
              <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-truck text-blue-600 text-2xl"></i>
              </div>
              <h3 class="text-lg font-semibold mb-2">Standard Shipping</h3>
              <p class="text-gray-600 mb-2">5-7 business days</p>
              <p class="text-2xl font-bold text-blue-600">FREE</p>
              <p class="text-sm text-gray-500">On orders over $50</p>
            </div>
            
            <div class="border border-gray-200 rounded-xl p-6 text-center">
              <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-shipping-fast text-green-600 text-2xl"></i>
              </div>
              <h3 class="text-lg font-semibold mb-2">Express Shipping</h3>
              <p class="text-gray-600 mb-2">2-3 business days</p>
              <p class="text-2xl font-bold text-green-600">$9.99</p>
              <p class="text-sm text-gray-500">Expedited delivery</p>
            </div>
            
            <div class="border border-gray-200 rounded-xl p-6 text-center">
              <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-bolt text-purple-600 text-2xl"></i>
              </div>
              <h3 class="text-lg font-semibold mb-2">Overnight</h3>
              <p class="text-gray-600 mb-2">Next business day</p>
              <p class="text-2xl font-bold text-purple-600">$24.99</p>
              <p class="text-sm text-gray-500">Order by 2 PM</p>
            </div>
          </div>
        </section>

        <!-- Processing Time -->
        <section>
          <h2 class="text-2xl font-bold text-gray-900 mb-4">Processing Time</h2>
          <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
            <p class="text-gray-700 mb-4">All orders are processed within 1-2 business days. Orders are not shipped or delivered on weekends or holidays.</p>
            <p class="text-gray-700">If we are experiencing a high volume of orders, shipments may be delayed by a few days. Please allow additional days in transit for delivery.</p>
          </div>
        </section>

        <!-- Shipping Locations -->
        <section>
          <h2 class="text-2xl font-bold text-gray-900 mb-4">Shipping Locations</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-3">Domestic Shipping</h3>
              <ul class="space-y-2 text-gray-700">
                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i> All 50 US States</li>
                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i> Washington DC</li>
                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i> Puerto Rico</li>
                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i> US Virgin Islands</li>
              </ul>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-3">International Shipping</h3>
              <ul class="space-y-2 text-gray-700">
                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i> Canada ($15.99)</li>
                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i> United Kingdom ($19.99)</li>
                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i> Australia ($24.99)</li>
                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i> European Union ($22.99)</li>
              </ul>
            </div>
          </div>
        </section>

        <!-- Order Tracking -->
        <section>
          <h2 class="text-2xl font-bold text-gray-900 mb-4">Order Tracking</h2>
          <div class="bg-gray-50 rounded-xl p-6">
            <p class="text-gray-700 mb-4">Once your order has shipped, you will receive an email with your tracking number and a link to track your package.</p>
            <div class="flex items-center space-x-4">
              <router-link to="/orders" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                Track Your Order
              </router-link>
              <span class="text-gray-500">or check your email for tracking details</span>
            </div>
          </div>
        </section>

        <!-- Shipping Restrictions -->
        <section>
          <h2 class="text-2xl font-bold text-gray-900 mb-4">Shipping Restrictions</h2>
          <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
            <ul class="space-y-2 text-gray-700">
              <li class="flex items-start"><i class="fas fa-exclamation-triangle text-yellow-600 mr-2 mt-1"></i> Some products may have shipping restrictions to certain locations</li>
              <li class="flex items-start"><i class="fas fa-exclamation-triangle text-yellow-600 mr-2 mt-1"></i> Hazardous materials cannot be shipped via air</li>
              <li class="flex items-start"><i class="fas fa-exclamation-triangle text-yellow-600 mr-2 mt-1"></i> Large items may require special handling fees</li>
              <li class="flex items-start"><i class="fas fa-exclamation-triangle text-yellow-600 mr-2 mt-1"></i> International orders may be subject to customs duties</li>
            </ul>
          </div>
        </section>

        <!-- Contact -->
        <section class="text-center">
          <h2 class="text-2xl font-bold text-gray-900 mb-4">Questions About Shipping?</h2>
          <p class="text-gray-600 mb-6">Our customer service team is here to help with any shipping questions.</p>
          <router-link to="/contact" class="px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
            Contact Support
          </router-link>
        </section>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ShippingView'
}
</script>