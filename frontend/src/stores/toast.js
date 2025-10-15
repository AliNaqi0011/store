import { defineStore } from 'pinia'

const activeIntervals = new Map()

export const useToastStore = defineStore('toast', {
  state: () => ({
    toasts: []
  }),

  actions: {
    addToast({ title, message = '', type = 'info', duration = 5000 }) {
      const id = crypto.randomUUID()
      const toast = {
        id,
        title,
        message,
        type,
        progress: 100
      }

      this.toasts.push(toast)

      // Auto remove after duration
      const interval = setInterval(() => {
        toast.progress -= (100 / duration) * 100
        if (toast.progress <= 0) {
          this.removeToast(id)
        }
      }, 100)
      
      activeIntervals.set(id, interval)
      return id
    },

    removeToast(id) {
      // Clear interval if exists
      const interval = activeIntervals.get(id)
      if (interval) {
        clearInterval(interval)
        activeIntervals.delete(id)
      }
      
      const index = this.toasts.findIndex(toast => toast.id === id)
      if (index > -1) {
        this.toasts.splice(index, 1)
      }
    },

    success(title, message = '') {
      return this.addToast({ title, message, type: 'success' })
    },

    error(title, message = '') {
      return this.addToast({ title, message, type: 'error', duration: 7000 })
    },

    warning(title, message = '') {
      return this.addToast({ title, message, type: 'warning' })
    },

    info(title, message = '') {
      return this.addToast({ title, message, type: 'info' })
    },
    
    clearAll() {
      // Clear all intervals
      activeIntervals.forEach(interval => clearInterval(interval))
      activeIntervals.clear()
      
      this.toasts = []
    }
  }
})