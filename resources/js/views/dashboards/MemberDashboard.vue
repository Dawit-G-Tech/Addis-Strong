<template>
  <div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white shadow-sm rounded-lg p-6">
      <h1 class="text-3xl font-bold text-gray-900">Member Dashboard</h1>
      <p class="text-gray-600 mt-2">Welcome back, {{ user.name }}! Ready for your next workout?</p>
    </div>

    <!-- Member Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="bg-green-100 p-3 rounded-full">
            <i class="fas fa-id-card text-green-600 text-xl"></i>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Membership Status</p>
            <p class="text-lg font-bold text-gray-900">{{ stats.membership_status || 'Active' }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="bg-blue-100 p-3 rounded-full">
            <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Classes Booked</p>
            <p class="text-lg font-bold text-gray-900">{{ stats.classes_booked || 0 }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="bg-purple-100 p-3 rounded-full">
            <i class="fas fa-chart-line text-purple-600 text-xl"></i>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Attendance Rate</p>
            <p class="text-lg font-bold text-gray-900">{{ stats.attendance_rate || 0 }}%</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Next Class -->
    <div v-if="stats.next_class" class="bg-white shadow-sm rounded-lg p-6">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Your Next Class</h2>
      <div class="bg-gradient-to-r from-purple-50 to-blue-50 p-6 rounded-lg">
        <div class="flex items-center justify-between">
          <div>
            <h3 class="text-lg font-semibold text-gray-900">{{ stats.next_class.class.name }}</h3>
            <p class="text-gray-600">{{ stats.next_class.class.description }}</p>
            <p class="text-sm text-gray-500 mt-2">
              <i class="fas fa-clock mr-1"></i>
              {{ formatDateTime(stats.next_class.class.date) }}
            </p>
          </div>
          <div class="text-right">
            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
              Booked
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white shadow-sm rounded-lg p-6">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <router-link 
          to="/member/classes" 
          class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition"
        >
          <i class="fas fa-dumbbell text-blue-600 text-xl mr-3"></i>
          <div>
            <p class="font-medium text-gray-900">Browse Classes</p>
            <p class="text-sm text-gray-600">Find and book classes</p>
          </div>
        </router-link>

        <router-link 
          to="/member/bookings" 
          class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition"
        >
          <i class="fas fa-calendar-alt text-green-600 text-xl mr-3"></i>
          <div>
            <p class="font-medium text-gray-900">My Bookings</p>
            <p class="text-sm text-gray-600">View your schedule</p>
          </div>
        </router-link>

        <router-link 
          to="/member/payments" 
          class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition"
        >
          <i class="fas fa-credit-card text-purple-600 text-xl mr-3"></i>
          <div>
            <p class="font-medium text-gray-900">Payments</p>
            <p class="text-sm text-gray-600">Manage payments</p>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'

export default {
  name: 'MemberDashboard',
  setup() {
    const user = ref({})
    const stats = ref({})

    const formatDateTime = (dateString) => {
      const date = new Date(dateString)
      return date.toLocaleString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      })
    }

    const loadDashboardData = async () => {
      try {
        const userResponse = await fetch('/api/user')
        if (userResponse.ok) {
          user.value = await userResponse.json()
        }

        // Load member-specific stats
        const statsResponse = await fetch('/api/member/dashboard-stats')
        if (statsResponse.ok) {
          stats.value = await statsResponse.json()
        }
      } catch (error) {
        console.error('Error loading dashboard data:', error)
      }
    }

    onMounted(() => {
      loadDashboardData()
    })

    return {
      user,
      stats,
      formatDateTime
    }
  }
}
</script>
