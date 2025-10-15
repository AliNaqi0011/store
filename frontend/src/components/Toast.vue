<template>
  <Teleport to="body">
    <div class="fixed top-4 right-4 z-50 space-y-2">
      <Transition
        v-for="toast in toasts"
        :key="toast.id"
        name="toast"
        appear
      >
        <div
          class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden"
        >
          <div class="p-4">
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <i
                  :class="getIconClass(toast.type)"
                  class="text-xl"
                ></i>
              </div>
              <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium text-gray-900">
                  {{ toast.title }}
                </p>
                <p v-if="toast.message" class="mt-1 text-sm text-gray-500">
                  {{ toast.message }}
                </p>
              </div>
              <div class="ml-4 flex-shrink-0 flex">
                <button
                  @click="removeToast(toast.id)"
                  class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none"
                >
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </div>
          <div
            class="h-1 bg-gradient-to-r"
            :class="getProgressClass(toast.type)"
            :style="{ width: toast.progress + '%' }"
          ></div>
        </div>
      </Transition>
    </div>
  </Teleport>
</template>

<script>
import { useToastStore } from '../stores/toast'

export default {
  name: 'Toast',
  setup() {
    const toastStore = useToastStore()
    return {
      toasts: toastStore.toasts,
      removeToast: toastStore.removeToast
    }
  },
  methods: {
    getIconClass(type) {
      const icons = {
        success: 'fas fa-check-circle text-green-500',
        error: 'fas fa-exclamation-circle text-red-500',
        warning: 'fas fa-exclamation-triangle text-yellow-500',
        info: 'fas fa-info-circle text-blue-500'
      }
      return icons[type] || icons.info
    },
    getProgressClass(type) {
      const classes = {
        success: 'from-green-500 to-green-600',
        error: 'from-red-500 to-red-600',
        warning: 'from-yellow-500 to-yellow-600',
        info: 'from-blue-500 to-blue-600'
      }
      return classes[type] || classes.info
    }
  }
}
</script>

<style scoped>
.toast-enter-active,
.toast-leave-active {
  transition: all 0.3s ease;
}

.toast-enter-from {
  opacity: 0;
  transform: translateX(100%);
}

.toast-leave-to {
  opacity: 0;
  transform: translateX(100%);
}
</style>