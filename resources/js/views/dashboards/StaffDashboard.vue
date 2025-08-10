<template>
  <div class="space-y-6">
    <div class="bg-white shadow-sm rounded-lg p-6">
      <h1 class="text-3xl font-bold text-gray-900">Staff Dashboard</h1>
      <p class="text-gray-600 mt-2">Welcome back, {{ user.name }}! Here's today's overview.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="bg-green-100 p-3 rounded-full">
            <i class="fas fa-sign-in-alt text-green-600 text-xl"></i>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Check-ins Today</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.check_ins_today || 0 }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="bg-blue-100 p-3 rounded-full">
            <i class="fas fa-tools text-blue-600 text-xl"></i>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Equipment Available</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.equipment_available || 0 }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="bg-yellow-100 p-3 rounded-full">
            <i class="fas fa-bell text-yellow-600 text-xl"></i>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Pending Notifications</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.pending_notifications || 0 }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'

export default {
  name: 'StaffDashboard',
  setup() {
    const user = ref({})
    const stats = ref({})

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
      stats
    }
  }
}
</script>
