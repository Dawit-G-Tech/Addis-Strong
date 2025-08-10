<template>
  <div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
      <!-- Profile Header -->
      <div class="bg-gradient-to-r from-purple-600 to-purple-800 px-6 py-8 text-white">
        <div class="flex items-center">
          <div class="relative">
            <img 
              :src="profileImage" 
              :alt="user.name"
              class="h-24 w-24 rounded-full border-4 border-white shadow-lg"
            >
            <button 
              @click="triggerFileInput"
              class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 transition"
            >
              <i class="fas fa-camera text-purple-600"></i>
            </button>
            <input 
              ref="fileInput"
              type="file" 
              accept="image/*" 
              @change="handleImageUpload" 
              class="hidden"
            >
          </div>
          <div class="ml-6">
            <h1 class="text-3xl font-bold">{{ user.name }}</h1>
            <p class="text-purple-200">{{ user.email }}</p>
            <div class="flex items-center mt-2">
              <span class="bg-purple-500 px-3 py-1 rounded-full text-sm font-medium">
                {{ user.role?.role_name || 'User' }}
              </span>
              <span class="ml-3 text-purple-200">
                Member since {{ formatDate(user.registration_date) }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Profile Content -->
      <div class="p-6">
        <!-- Navigation Tabs -->
        <div class="border-b border-gray-200 mb-6">
          <nav class="flex space-x-8">
            <button 
              @click="activeTab = 'profile'"
              :class="[
                'py-2 px-1 border-b-2 font-medium text-sm',
                activeTab === 'profile' 
                  ? 'border-purple-500 text-purple-600' 
                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
              ]"
            >
              Profile Information
            </button>
            <button 
              @click="activeTab = 'security'"
              :class="[
                'py-2 px-1 border-b-2 font-medium text-sm',
                activeTab === 'security' 
                  ? 'border-purple-500 text-purple-600' 
                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
              ]"
            >
              Security
            </button>
          </nav>
        </div>

        <!-- Profile Information Tab -->
        <div v-if="activeTab === 'profile'" class="space-y-6">
          <form @submit.prevent="updateProfile" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Full Name
                </label>
                <input 
                  v-model="profileForm.name"
                  type="text" 
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                  required
                >
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Email
                </label>
                <input 
                  v-model="profileForm.email"
                  type="email" 
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                  required
                >
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Gender
                </label>
                <select 
                  v-model="profileForm.gender"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                  <option value="other">Other</option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Date of Birth
                </label>
                <input 
                  v-model="profileForm.dob"
                  type="date" 
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
              </div>
            </div>

            <div class="flex justify-end space-x-4">
              <button 
                type="button"
                @click="resetProfileForm"
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition"
              >
                Cancel
              </button>
              <button 
                type="submit"
                :disabled="updating"
                class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 disabled:opacity-50 transition"
              >
                <i v-if="updating" class="fas fa-spinner fa-spin mr-2"></i>
                {{ updating ? 'Updating...' : 'Update Profile' }}
              </button>
            </div>
          </form>
        </div>

        <!-- Security Tab -->
        <div v-if="activeTab === 'security'" class="space-y-6">
          <form @submit.prevent="updatePassword" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Current Password
                </label>
                <input 
                  v-model="passwordForm.current_password"
                  type="password" 
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                  required
                >
              </div>

              <div></div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  New Password
                </label>
                <input 
                  v-model="passwordForm.password"
                  type="password" 
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                  required
                >
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Confirm New Password
                </label>
                <input 
                  v-model="passwordForm.password_confirmation"
                  type="password" 
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                  required
                >
              </div>
            </div>

            <div class="flex justify-end space-x-4">
              <button 
                type="button"
                @click="resetPasswordForm"
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition"
              >
                Cancel
              </button>
              <button 
                type="submit"
                :disabled="updatingPassword"
                class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 disabled:opacity-50 transition"
              >
                <i v-if="updatingPassword" class="fas fa-spinner fa-spin mr-2"></i>
                {{ updatingPassword ? 'Updating...' : 'Update Password' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Success/Error Messages -->
    <div v-if="message" class="mt-4 p-4 rounded-md" :class="messageType === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'">
      {{ message }}
    </div>
  </div>
</template>

<script>
import { ref, reactive, computed, onMounted } from 'vue'

export default {
  name: 'Profile',
  setup() {
    const activeTab = ref('profile')
    const updating = ref(false)
    const updatingPassword = ref(false)
    const message = ref('')
    const messageType = ref('success')
    const fileInput = ref(null)

    const user = ref({})
    const profileForm = reactive({
      name: '',
      email: '',
      gender: '',
      dob: ''
    })

    const passwordForm = reactive({
      current_password: '',
      password: '',
      password_confirmation: ''
    })

    const profileImage = computed(() => {
      return user.value.profile_picture || '/images/default-avatar.png'
    })

    const formatDate = (dateString) => {
      if (!dateString) return 'N/A'
      return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    }

    const loadUserData = async () => {
      try {
        const response = await fetch('/api/user')
        if (response.ok) {
          const userData = await response.json()
          user.value = userData
          
          // Populate form with current user data
          profileForm.name = userData.name || ''
          profileForm.email = userData.email || ''
          profileForm.gender = userData.gender || ''
          profileForm.dob = userData.dob ? userData.dob.split('T')[0] : ''
        }
      } catch (error) {
        console.error('Error loading user data:', error)
        showMessage('Error loading user data', 'error')
      }
    }

    const updateProfile = async () => {
      try {
        updating.value = true
        const response = await fetch('/api/profile', {
          method: 'PATCH',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify(profileForm)
        })

        if (response.ok) {
          const updatedUser = await response.json()
          user.value = updatedUser
          showMessage('Profile updated successfully!', 'success')
        } else {
          const error = await response.json()
          showMessage(error.message || 'Error updating profile', 'error')
        }
      } catch (error) {
        console.error('Error updating profile:', error)
        showMessage('Error updating profile', 'error')
      } finally {
        updating.value = false
      }
    }

    const updatePassword = async () => {
      if (passwordForm.password !== passwordForm.password_confirmation) {
        showMessage('Passwords do not match', 'error')
        return
      }

      try {
        updatingPassword.value = true
        const response = await fetch('/api/profile/password', {
          method: 'PATCH',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify(passwordForm)
        })

        if (response.ok) {
          showMessage('Password updated successfully!', 'success')
          resetPasswordForm()
        } else {
          const error = await response.json()
          showMessage(error.message || 'Error updating password', 'error')
        }
      } catch (error) {
        console.error('Error updating password:', error)
        showMessage('Error updating password', 'error')
      } finally {
        updatingPassword.value = false
      }
    }

    const triggerFileInput = () => {
      fileInput.value.click()
    }

    const handleImageUpload = async (event) => {
      const file = event.target.files[0]
      if (!file) return

      const formData = new FormData()
      formData.append('profile_picture', file)

      try {
        const response = await fetch('/api/profile/avatar', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: formData
        })

        if (response.ok) {
          const result = await response.json()
          user.value.profile_picture = result.profile_picture
          showMessage('Profile picture updated successfully!', 'success')
        } else {
          showMessage('Error uploading profile picture', 'error')
        }
      } catch (error) {
        console.error('Error uploading image:', error)
        showMessage('Error uploading profile picture', 'error')
      }
    }

    const resetProfileForm = () => {
      profileForm.name = user.value.name || ''
      profileForm.email = user.value.email || ''
      profileForm.gender = user.value.gender || ''
      profileForm.dob = user.value.dob ? user.value.dob.split('T')[0] : ''
    }

    const resetPasswordForm = () => {
      passwordForm.current_password = ''
      passwordForm.password = ''
      passwordForm.password_confirmation = ''
    }

    const showMessage = (msg, type = 'success') => {
      message.value = msg
      messageType.value = type
      setTimeout(() => {
        message.value = ''
      }, 5000)
    }

    onMounted(() => {
      loadUserData()
    })

    return {
      activeTab,
      user,
      profileForm,
      passwordForm,
      updating,
      updatingPassword,
      message,
      messageType,
      fileInput,
      profileImage,
      formatDate,
      updateProfile,
      updatePassword,
      resetProfileForm,
      resetPasswordForm,
      triggerFileInput,
      handleImageUpload
    }
  }
}
</script>
