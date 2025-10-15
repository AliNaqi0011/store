import { defineStore } from 'pinia'
import apiClient from '../config/api'

export const useSettingsStore = defineStore('settings', {
  state: () => ({
    settings: {
      site_name: 'NexShop',
      site_tagline: 'Your Premium E-Commerce Destination',
      primary_color: '#3b82f6',
      secondary_color: '#8b5cf6',
      accent_color: '#f59e0b',
      font_family: 'Inter',
      logo_url: null,
      favicon_url: null,
      contact_email: 'support@nexshop.com',
      contact_phone: '+1 (555) 123-4567',
      social_links: {},
      currency_symbol: '$'
    },
    loaded: false
  }),

  actions: {
    async fetchSettings() {
      try {
        const response = await apiClient.get('/settings')
        this.settings = { ...this.settings, ...response.data }
        this.applyTheme()
        this.loaded = true
      } catch (error) {
        console.error('Error fetching settings:', error)
      }
    },

    applyTheme() {
      // Apply CSS custom properties
      const root = document.documentElement
      root.style.setProperty('--primary-color', this.settings.primary_color)
      root.style.setProperty('--secondary-color', this.settings.secondary_color)
      root.style.setProperty('--accent-color', this.settings.accent_color)
      
      // Apply font family
      document.body.style.fontFamily = this.settings.font_family + ', system-ui, sans-serif'
      
      // Update page title
      document.title = this.settings.site_name
      
      // Update favicon if provided
      if (this.settings.favicon_url) {
        let favicon = document.querySelector('link[rel="icon"]')
        if (!favicon) {
          favicon = document.createElement('link')
          favicon.rel = 'icon'
          document.head.appendChild(favicon)
        }
        favicon.href = this.settings.favicon_url
      }
    }
  }
})