<template>
  <div class="space-y-6">
    <div class="bg-white shadow-sm rounded-lg p-6">
      <h1 class="text-3xl font-bold text-gray-900">Trainer Dashboard</h1>
      <p class="text-gray-600 mt-2">Welcome back, {{ user.name }}! Ready to inspire today?</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="bg-blue-100 p-3 rounded-full">
            <i class="fas fa-dumbbell text-blue-600 text-xl"></i>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">My Classes</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.my_classes || 0 }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="bg-green-100 p-3 rounded-full">
            <i class="fas fa-calendar-check text-green-600 text-xl"></i>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Upcoming Sessions</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.upcoming_sessions || 0 }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
          <div class="bg-purple-100 p-3 rounded-full">
            <i class="fas fa-users text-purple-600 text-xl"></i>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Members Trained</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.total_members_trained || 0 }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'

export default {
  name: 'TrainerDashboard',
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
