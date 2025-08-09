<template>
  <div class="classes">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Classes</h1>
      <p class="mt-2 text-gray-600 dark:text-gray-400">Manage your gym classes</p>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
      <div class="p-6">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">All Classes</h2>
          <button 
            @click="showCreateModal = true"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
          >
            Add Class
          </button>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Trainer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Schedule</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Duration</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Capacity</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
              <tr v-for="classItem in classes" :key="classItem.class_id">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ classItem.name }}</div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900 dark:text-gray-100">{{ classItem.description }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900 dark:text-gray-100">{{ classItem.trainer?.name }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900 dark:text-gray-100">{{ formatDateTime(classItem.schedule_time) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900 dark:text-gray-100">{{ classItem.duration_minutes }} min</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900 dark:text-gray-100">{{ classItem.capacity }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button @click="editClass(classItem)" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                  <button @click="deleteClass(classItem.class_id)" class="text-red-600 hover:text-red-900">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
  name: 'Classes',
  setup() {
    const classes = ref([]);
    const showCreateModal = ref(false);

    const fetchClasses = async () => {
      try {
        const response = await axios.get('/api/classes');
        classes.value = response.data;
      } catch (error) {
        console.error('Error fetching classes:', error);
      }
    };

    const formatDateTime = (dateTime) => {
      return new Date(dateTime).toLocaleString();
    };

    const editClass = (classItem) => {
      console.log('Edit class:', classItem);
    };

    const deleteClass = async (classId) => {
      if (confirm('Are you sure you want to delete this class?')) {
        try {
          await axios.delete(`/api/classes/${classId}`);
          await fetchClasses();
        } catch (error) {
          console.error('Error deleting class:', error);
        }
      }
    };

    onMounted(() => {
      fetchClasses();
    });

    return {
      classes,
      showCreateModal,
      formatDateTime,
      editClass,
      deleteClass
    };
  }
};
</script>
