export const handleApiError = (error) => {
  if (!error) {
    return 'Unknown error occurred'
  }
  
  if (error.response) {
    const status = error.response.status
    const message = error.response.data?.message || 'An error occurred'
    
    switch (status) {
      case 401:
        // Don't redirect immediately, let the app handle auth state
        break
      case 404:
        showNotification('Resource not found', 'error')
        break
      case 500:
        showNotification('Server error. Please try again later.', 'error')
        break
      default:
        showNotification(message, 'error')
    }
    return message
  } else {
    const message = 'Network error. Please check your connection.'
    showNotification(message, 'error')
    return message
  }
}

let notificationContainer = null
let notificationCount = 0
const MAX_NOTIFICATIONS = 5

export const showNotification = (message, type = 'info') => {
  if (!message) return
  
  // Create container if it doesn't exist
  if (!notificationContainer) {
    notificationContainer = document.createElement('div')
    notificationContainer.className = 'notification-container'
    document.body.appendChild(notificationContainer)
  }
  
  // Limit concurrent notifications
  if (notificationCount >= MAX_NOTIFICATIONS) {
    return
  }
  
  const notification = document.createElement('div')
  notification.className = `notification notification-${type}`
  notification.textContent = message
  
  notificationContainer.appendChild(notification)
  notificationCount++
  
  // Remove after 5 seconds
  const timeoutId = setTimeout(() => {
    removeNotification(notification)
  }, 5000)
  
  // Allow manual dismissal
  notification.addEventListener('click', () => {
    clearTimeout(timeoutId)
    removeNotification(notification)
  })
}

function removeNotification(notification) {
  if (notification && notification.parentNode) {
    notification.parentNode.removeChild(notification)
    notificationCount--
  }
}