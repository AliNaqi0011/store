<template>
  <div id="app">
    <AppHeader />
    <main>
      <router-view />
    </main>
    <AppFooter />
    <CartSidebar />
    <Toast />
  </div>
</template>

<script>
import AppHeader from './components/AppHeader.vue'
import AppFooter from './components/AppFooter.vue'
import CartSidebar from './components/CartSidebar.vue'
import ErrorBoundary from './components/ErrorBoundary.vue'
import Toast from './components/Toast.vue'
import { useAuthStore } from './stores/auth'
import { useCartStore } from './stores/cart'
import { useSettingsStore } from './stores/settings'

export default {
  name: 'App',
  components: {
    AppHeader,
    AppFooter,
    CartSidebar,
    ErrorBoundary,
    Toast
  },
  async created() {
    const authStore = useAuthStore()
    const cartStore = useCartStore()
    const settingsStore = useSettingsStore()
    
    // Load settings first to apply theme
    await settingsStore.fetchSettings()
    
    // Don't automatically fetch user to avoid 401 errors
    // Auth check will happen in router guards when needed
    
    await cartStore.fetchCart()
  }
}
</script>