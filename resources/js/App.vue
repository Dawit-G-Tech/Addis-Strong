<template>
  <div id="app">
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <div class="shrink-0 flex items-center">
              <router-link to="/" class="text-xl font-bold text-gray-800 dark:text-gray-200">
                GMS
              </router-link>
            </div>
          </div>
          <div class="hidden sm:flex sm:items-center sm:ms-6">
            <router-link 
              v-for="item in navigationItems" 
              :key="item.path"
              :to="item.path"
              class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white"
              :class="{ 'bg-gray-900 text-white': $route.path === item.path }"
            >
              {{ item.name }}
            </router-link>
          </div>
        </div>
      </div>
    </nav>

    <main class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <router-view />
      </div>
    </main>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      navigationItems: [
        { name: 'Dashboard', path: '/' },
        { name: 'Members', path: '/members' },
        { name: 'Staff', path: '/staff' },
        { name: 'Classes', path: '/classes' },
        { name: 'Payments', path: '/payments' },
        { name: 'Memberships', path: '/memberships' },
      ]
    }
  }
}
</script>

<style>
#app {
  font-family: 'Inter', sans-serif;
}
</style>
