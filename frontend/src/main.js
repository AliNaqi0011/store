import { createApp } from 'vue'
import { createPinia } from 'pinia'
import router from './router'
import App from './App.vue'
import './assets/css/mobile.css'
import './assets/css/components.css'

const app = createApp(App)
app.use(createPinia())
app.use(router)
app.mount('#app')