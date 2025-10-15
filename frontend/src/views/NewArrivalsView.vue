<template>
  <div class="min-h-screen bg-white">
    <!-- Hero Section - Sapphire Luxury Style -->
    <div class="relative bg-gradient-to-b from-slate-50 to-white">
      <div class="absolute inset-0 opacity-50" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23f1f5f9&quot; fill-opacity=&quot;0.4&quot;%3E%3Ccircle cx=&quot;30&quot; cy=&quot;30&quot; r=&quot;1.5&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
      <div class="relative max-w-7xl mx-auto px-4 py-20">
        <div class="text-center">
          <div class="inline-flex items-center bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-2 rounded-full text-sm font-medium mb-6 shadow-lg">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
            </svg>
            NEW ARRIVALS
          </div>
          <h1 class="text-5xl md:text-6xl font-light text-slate-900 mb-6 tracking-tight">
            Latest <span class="font-semibold text-emerald-600">Collection</span>
          </h1>
          <p class="text-xl text-slate-600 max-w-3xl mx-auto mb-12 leading-relaxed">
            Discover the newest additions to our curated selection. 
            Fresh styles and trending pieces, updated daily.
          </p>
          
          <!-- Stats - Luxury Style -->
          <div class="flex items-center justify-center space-x-12 text-slate-600">
            <div class="text-center">
              <div class="text-2xl font-light text-slate-900 mb-1">150+</div>
              <div class="text-sm uppercase tracking-wider">New Products</div>
            </div>
            <div class="w-px h-12 bg-slate-300"></div>
            <div class="text-center">
              <div class="text-2xl font-light text-slate-900 mb-1">Daily</div>
              <div class="text-sm uppercase tracking-wider">Updates</div>
            </div>
            <div class="w-px h-12 bg-slate-300"></div>
            <div class="text-center">
              <div class="text-2xl font-light text-slate-900 mb-1">Trending</div>
              <div class="text-sm uppercase tracking-wider">Styles</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-16">
      <!-- Filter Tabs - Sapphire Luxury Style -->
      <div class="mb-16">
        <div class="flex flex-wrap justify-center gap-3">
          <button 
            v-for="category in categories" 
            :key="category.id"
            @click="activeCategory = category.id"
            :class="activeCategory === category.id ? 'bg-gradient-to-r from-slate-900 to-slate-800 text-white border-slate-900 shadow-lg' : 'bg-white text-slate-700 border-slate-200 hover:border-slate-300 hover:shadow-md'"
            class="px-6 py-3 rounded-2xl font-medium transition-all duration-300 border transform hover:scale-105"
          >
            {{ category.name }}
          </button>
        </div>
      </div>

      <!-- New Arrivals Grid -->
      <div class="mb-16">
        <div class="text-center mb-12">
          <h2 class="text-4xl font-bold text-gray-900 mb-4">🌟 Latest Additions</h2>
          <p class="text-xl text-gray-600">Discover what's new and trending</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div v-for="product in filteredProducts" :key="product.id" class="bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg hover:border-gray-300 transition-all duration-300 group">
            <div class="relative overflow-hidden">
              <img :src="product.image" :alt="product.name" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
              <div class="absolute top-3 left-3">
                <span class="bg-green-600 text-white px-2 py-1 rounded-lg text-xs font-semibold">
                  NEW
                </span>
              </div>
              <div class="absolute top-3 right-3 bg-white bg-opacity-90 backdrop-blur-sm px-2 py-1 rounded-lg">
                <span class="text-xs font-medium text-gray-700">{{ product.daysAgo }}d ago</span>
              </div>
              <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300 flex items-center justify-center">
                <button class="bg-white text-gray-900 px-4 py-2 rounded-lg font-medium opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300 shadow-lg">
                  Quick View
                </button>
              </div>
            </div>
            <div class="p-4">
              <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-blue-600 font-semibold uppercase tracking-wide">{{ product.category }}</span>
                <div class="flex items-center">
                  <div class="flex text-yellow-400 mr-1">
                    <svg v-for="n in 5" :key="n" :class="n <= product.rating ? 'text-yellow-400' : 'text-gray-300'" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                  </div>
                  <span class="text-xs text-gray-500">({{ product.reviews }})</span>
                </div>
              </div>
              <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ product.name }}</h3>
              <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ product.description }}</p>
              <div class="flex items-center justify-between mb-4">
                <span class="text-xl font-bold text-gray-900">${{ product.price }}</span>
              </div>
              <button class="w-full bg-gray-900 text-white py-2.5 rounded-xl font-medium hover:bg-gray-800 transition-colors flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                </svg>
                Add to Cart
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Trending Categories -->
      <div class="mb-16">
        <div class="text-center mb-12">
          <h2 class="text-4xl font-bold text-gray-900 mb-4">🔥 Trending Categories</h2>
          <p class="text-xl text-gray-600">What's hot right now</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="bg-gradient-to-br from-red-500 to-pink-500 rounded-3xl p-8 text-white text-center hover:scale-105 transition-transform cursor-pointer">
            <div class="text-6xl mb-4">👕</div>
            <h3 class="text-2xl font-bold mb-2">Fashion</h3>
            <p class="text-red-100 mb-4">Latest clothing trends</p>
            <div class="bg-white bg-opacity-20 rounded-full px-4 py-2 inline-block">
              <span class="text-sm font-semibold">25 New Items</span>
            </div>
          </div>
          
          <div class="bg-gradient-to-br from-blue-500 to-cyan-500 rounded-3xl p-8 text-white text-center hover:scale-105 transition-transform cursor-pointer">
            <div class="text-6xl mb-4">📱</div>
            <h3 class="text-2xl font-bold mb-2">Electronics</h3>
            <p class="text-blue-100 mb-4">Cutting-edge technology</p>
            <div class="bg-white bg-opacity-20 rounded-full px-4 py-2 inline-block">
              <span class="text-sm font-semibold">18 New Items</span>
            </div>
          </div>
          
          <div class="bg-gradient-to-br from-green-500 to-teal-500 rounded-3xl p-8 text-white text-center hover:scale-105 transition-transform cursor-pointer">
            <div class="text-6xl mb-4">🏠</div>
            <h3 class="text-2xl font-bold mb-2">Home & Living</h3>
            <p class="text-green-100 mb-4">Modern home essentials</p>
            <div class="bg-white bg-opacity-20 rounded-full px-4 py-2 inline-block">
              <span class="text-sm font-semibold">32 New Items</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Coming Soon -->
      <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-3xl p-12 text-white text-center">
        <div class="w-20 h-20 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
          <i class="fas fa-rocket text-3xl"></i>
        </div>
        <h2 class="text-4xl font-bold mb-4">🚀 Coming Soon</h2>
        <p class="text-xl text-gray-300 mb-8">Get ready for our biggest collection launch yet!</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
          <div class="bg-white bg-opacity-10 rounded-2xl p-6">
            <div class="text-3xl mb-2">⌚</div>
            <h3 class="font-bold mb-2">Smart Wearables</h3>
            <p class="text-sm text-gray-300">Next-gen fitness trackers</p>
          </div>
          <div class="bg-white bg-opacity-10 rounded-2xl p-6">
            <div class="text-3xl mb-2">🎮</div>
            <h3 class="font-bold mb-2">Gaming Gear</h3>
            <p class="text-sm text-gray-300">Professional gaming equipment</p>
          </div>
          <div class="bg-white bg-opacity-10 rounded-2xl p-6">
            <div class="text-3xl mb-2">🌱</div>
            <h3 class="font-bold mb-2">Eco-Friendly</h3>
            <p class="text-sm text-gray-300">Sustainable lifestyle products</p>
          </div>
        </div>
        <button class="bg-gradient-to-r from-yellow-500 to-orange-500 text-black px-8 py-4 rounded-xl font-bold hover:from-yellow-600 hover:to-orange-600 transition-all transform hover:scale-105">
          <i class="fas fa-bell mr-2"></i>Notify Me
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'NewArrivalsView',
  data() {
    return {
      activeCategory: 'all',
      categories: [
        { id: 'all', name: 'All Items', icon: 'fas fa-th-large' },
        { id: 'fashion', name: 'Fashion', icon: 'fas fa-tshirt' },
        { id: 'electronics', name: 'Electronics', icon: 'fas fa-laptop' },
        { id: 'home', name: 'Home & Living', icon: 'fas fa-home' },
        { id: 'beauty', name: 'Beauty', icon: 'fas fa-heart' },
        { id: 'sports', name: 'Sports', icon: 'fas fa-dumbbell' }
      ],
      products: []
    }
  },
  mounted() {
    this.fetchNewArrivals()
  },
  computed: {
    filteredProducts() {
      if (this.activeCategory === 'all') {
        return this.products
      }
      return this.products.filter(product => product.categoryId === this.activeCategory)
    }
  },
  methods: {
    async fetchNewArrivals() {
      try {
        const response = await fetch('/api/new-arrivals')
        const data = await response.json()
        if (data.success) {
          this.products = data.data.data.map(product => ({
            id: product.id,
            name: product.name,
            category: product.category?.name || 'General',
            categoryId: product.category?.slug || 'general',
            image: product.primary_image || 'https://via.placeholder.com/400x300?text=Product',
            price: product.price,
            rating: product.rating || 5,
            reviews: product.reviews_count || 0,
            description: product.short_description || product.description,
            daysAgo: Math.floor((new Date() - new Date(product.created_at)) / (1000 * 60 * 60 * 24))
          }))
        }
      } catch (error) {
        console.error('Error fetching new arrivals:', error)
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
</style>