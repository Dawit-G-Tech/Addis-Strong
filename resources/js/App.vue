<template>
  <div id="app">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <div class="shrink-0 flex items-center">
              <router-link to="/" class="text-xl font-bold text-purple-600">
                <i class="fas fa-dumbbell mr-2"></i>PowerFit
              </router-link>
            </div>
          </div>
          
          <!-- Navigation Links -->
          <div class="hidden sm:flex sm:items-center sm:ms-6">
            <router-link 
              v-for="item in navigationItems" 
              :key="item.path"
              :to="item.path"
              class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition"
              :class="{ 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300': $route.path === item.path }"
            >
              {{ item.name }}
            </router-link>
          </div>

          <!-- User Menu -->
          <div class="flex items-center sm:ms-6" v-if="isAuthenticated">
            <div class="relative">
              <button @click="toggleUserMenu" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                <img class="h-8 w-8 rounded-full" :src="userAvatar" :alt="user.name">
                <span class="ml-2 text-gray-700 dark:text-gray-300">{{ user.name }}</span>
                <i class="fas fa-chevron-down ml-1 text-gray-400"></i>
              </button>
              
              <!-- Dropdown Menu -->
              <div v-if="showUserMenu" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50">
                <router-link to="/profile" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                  <i class="fas fa-user mr-2"></i>Profile
                </router-link>
                <button @click="logout" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                  <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="py-8">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <router-view />
      </div>
    </main>

    <!-- Loading Overlay -->
    <div v-if="loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600 mx-auto"></div>
        <p class="mt-2 text-gray-600">Loading...</p>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'

export default {
  name: 'App',
  setup() {
    const router = useRouter()
    const loading = ref(false)
    const showUserMenu = ref(false)
    const isAuthenticated = ref(false)
    const user = ref({})
    const userRole = ref('')

    // Navigation items based on user role
    const navigationItems = computed(() => {
      if (!isAuthenticated.value) return []

      const baseItems = [
        { name: 'Dashboard', path: `/${userRole.value}/dashboard` }
      ]

      switch (userRole.value) {
        case 'admin':
          return [
            ...baseItems,
            { name: 'Members', path: '/admin/members' },
            { name: 'Staff', path: '/admin/staff' },
            { name: 'Classes', path: '/admin/classes' },
            { name: 'Payments', path: '/admin/payments' },
            { name: 'Memberships', path: '/admin/memberships' }
          ]
        case 'manager':
          return [
            ...baseItems,
            { name: 'Members', path: '/manager/members' },
            { name: 'Classes', path: '/manager/classes' },
            { name: 'Payments', path: '/manager/payments' },
            { name: 'Memberships', path: '/manager/memberships' }
          ]
        case 'trainer':
          return [
            ...baseItems,
            { name: 'My Classes', path: '/trainer/classes' },
            { name: 'Sessions', path: '/trainer/sessions' }
          ]
        case 'staff':
          return [
            ...baseItems,
            { name: 'Attendance', path: '/staff/attendance' },
            { name: 'Equipment', path: '/staff/equipment' }
          ]
        case 'member':
          return [
            ...baseItems,
            { name: 'Classes', path: '/member/classes' },
            { name: 'Bookings', path: '/member/bookings' },
            { name: 'Payments', path: '/member/payments' }
          ]
        default:
          return baseItems
      }
    })

    const userAvatar = computed(() => {
      return user.value.profile_picture || '/images/default-avatar.png'
    })

    const toggleUserMenu = () => {
      showUserMenu.value = !showUserMenu.value
    }

    const logout = async () => {
      try {
        loading.value = true
        const response = await fetch('/logout', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
          }
        })

        if (response.ok) {
          isAuthenticated.value = false
          user.value = {}
          userRole.value = ''
          showUserMenu.value = false
          router.push('/')
        }
      } catch (error) {
        console.error('Logout error:', error)
      } finally {
        loading.value = false
      }
    }

    const checkAuth = async () => {
      try {
        const response = await fetch('/api/user')
        if (response.ok) {
          const userData = await response.json()
          user.value = userData
          userRole.value = userData.role?.role_name || 'user'
          isAuthenticated.value = true
        }
      } catch (error) {
        console.error('Auth check error:', error)
      }
    }

    onMounted(() => {
      checkAuth()
      
      // Close user menu when clicking outside
      document.addEventListener('click', (e) => {
        if (!e.target.closest('.relative')) {
          showUserMenu.value = false
        }
      })
    })

    return {
      loading,
      showUserMenu,
      isAuthenticated,
      user,
      userRole,
      navigationItems,
      userAvatar,
      toggleUserMenu,
      logout
    }
  }
}
</script>

<style>
#app {
  font-family: 'Inter', sans-serif;
}

.router-link-active {
  background-color: rgb(243 244 246);
  color: rgb(107 33 168);
}

.dark .router-link-active {
  background-color: rgb(55 65 81);
  color: rgb(196 181 253);
}
</style>
