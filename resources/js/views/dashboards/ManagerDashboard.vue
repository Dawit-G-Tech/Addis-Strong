<template>
  <div class="space-y-6">
    <div class="bg-white shadow-sm rounded-lg p-6">
      <h1 class="text-3xl font-bold text-gray-900">Manager Dashboard</h1>
      <p class="text-gray-600 mt-2">Welcome back, {{ user.name }}! Here's your gym overview.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
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
            <i class="fas fa-id-card text-green-600 text-xl"></i>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Active Memberships</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.active_memberships || 0 }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="bg-yellow-100 p-3 rounded-full">
            <i class="fas fa-dollar-sign text-yellow-600 text-xl"></i>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Monthly Revenue</p>
            <p class="text-2xl font-bold text-gray-900">${{ formatCurrency(stats.monthly_revenue || 0) }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="bg-purple-100 p-3 rounded-full">
            <i class="fas fa-calendar text-purple-600 text-xl"></i>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Upcoming Classes</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.upcoming_classes || 0 }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'

export default {
  name: 'ManagerDashboard',
  setup() {
    const user = ref({})
    const stats = ref({})

    const formatCurrency = (amount) => {
      return new Intl.NumberFormat('en-US').format(amount)
    }

    const loadDashboardData = async () => {
      try {
        const userResponse = await fetch('/api/user')
        if (userResponse.ok) {
          user.value = await userResponse.json()
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
      formatCurrency
    }
  }
}
</script>
