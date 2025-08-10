<template>
  <div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white shadow-sm rounded-lg p-6">
      <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
      <p class="text-gray-600 mt-2">Welcome back, {{ user.name }}! Here's what's happening at PowerFit today.</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="bg-blue-100 p-3 rounded-full">
            <i class="fas fa-users text-blue-600 text-xl"></i>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Members</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.total_members || 0 }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="bg-green-100 p-3 rounded-full">
            <i class="fas fa-user-tie text-green-600 text-xl"></i>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Staff</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.total_staff || 0 }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="bg-purple-100 p-3 rounded-full">
            <i class="fas fa-dumbbell text-purple-600 text-xl"></i>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Active Classes</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.total_classes || 0 }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="bg-yellow-100 p-3 rounded-full">
            <i class="fas fa-dollar-sign text-yellow-600 text-xl"></i>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Revenue</p>
            <p class="text-2xl font-bold text-gray-900">${{ formatCurrency(stats.total_payments || 0) }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white shadow-sm rounded-lg p-6">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <router-link 
          to="/admin/members" 
          class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition"
        >
          <i class="fas fa-user-plus text-blue-600 text-xl mr-3"></i>
          <div>
            <p class="font-medium text-gray-900">Add Member</p>
            <p class="text-sm text-gray-600">Register new member</p>
          </div>
        </router-link>

        <router-link 
          to="/admin/staff" 
          class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition"
        >
          <i class="fas fa-user-tie text-green-600 text-xl mr-3"></i>
          <div>
            <p class="font-medium text-gray-900">Manage Staff</p>
            <p class="text-sm text-gray-600">View and edit staff</p>
          </div>
        </router-link>

        <router-link 
          to="/admin/classes" 
          class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition"
        >
          <i class="fas fa-calendar-plus text-purple-600 text-xl mr-3"></i>
          <div>
            <p class="font-medium text-gray-900">Schedule Class</p>
            <p class="text-sm text-gray-600">Create new class</p>
          </div>
        </router-link>
      </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white shadow-sm rounded-lg p-6">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Activity</h2>
      <div class="space-y-4">
        <div v-for="activity in recentActivity" :key="activity.id" class="flex items-center p-4 border border-gray-100 rounded-lg">
          <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
              <i :class="activity.icon" class="text-blue-600 text-sm"></i>
            </div>
          </div>
          <div class="ml-4 flex-1">
            <p class="text-sm font-medium text-gray-900">{{ activity.title }}</p>
            <p class="text-sm text-gray-600">{{ activity.description }}</p>
          </div>
          <div class="text-sm text-gray-500">
            {{ formatTime(activity.created_at) }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'

export default {
  name: 'AdminDashboard',
  setup() {
    const user = ref({})
    const stats = ref({})
    const recentActivity = ref([])

    const formatCurrency = (amount) => {
      return new Intl.NumberFormat('en-US').format(amount)
    }

    const formatTime = (dateString) => {
      const date = new Date(dateString)
      const now = new Date()
      const diffInHours = Math.floor((now - date) / (1000 * 60 * 60))
      
      if (diffInHours < 1) return 'Just now'
      if (diffInHours < 24) return `${diffInHours}h ago`
      return date.toLocaleDateString()
    }

    const loadDashboardData = async () => {
      try {
        // Load user data
        const userResponse = await fetch('/api/user')
        if (userResponse.ok) {
          user.value = await userResponse.json()
        }

        // Load dashboard stats
        const statsResponse = await fetch('/api/dashboard/stats')
        if (statsResponse.ok) {
          stats.value = await statsResponse.json()
        }

        // Load recent activity
        const activityResponse = await fetch('/api/dashboard/recent-activity')
        if (activityResponse.ok) {
          recentActivity.value = await activityResponse.json()
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
      recentActivity,
      formatCurrency,
      formatTime
    }
  }
}
</script>
