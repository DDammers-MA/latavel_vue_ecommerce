
<template>

    <div v-if="CurrentUser.id" class="min-h-full bg-gray-200 flex ">
      <!-- siderbar -->
     <sidebar :class="{'-ml-[200px]': !sidebarOpend}"/>

   <!-- siderbar -->
    <div class="flex-1">
  <Navbar @toggle-sidebar="toggleSidebar"></Navbar>
    
    <!-- content -->
    <main class="p-6">
     <div class="p-4 rounded bg-white">
      <router-view ></router-view>
     </div>
    </main>

        <!-- content -->
    </div>
    </div>

    <div v-else class="min-h-full bg-gray-200 flex items-center justify-center">
      <svg
            class="animate-spin -ml-1 mr-3 h-16 w-16 text-gray-500"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
          >
            <circle
              class="opacity-25"
              cx="12"
              cy="12"
              r="10"
              stroke="currentColor"
              stroke-width="4"
            ></circle>
            <path
              class="opacity-75"
              fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
            ></path>
          </svg>
          <span>please wait....</span>
    </div>
  </template>

  <script setup>
  import { ref, onMounted, onUnmounted, computed } from 'vue';
  import sidebar from './Sidebar.vue';
import Navbar from './Navbar.vue';
  import store from '../store';

const {title} = defineProps({
 title: String
})


  const sidebarOpend = ref(true)

  const CurrentUser = computed(() => store.state.user.data);

  
  function toggleSidebar() {
 sidebarOpend.value = !sidebarOpend.value
  }

  onMounted(() => {
    store.dispatch('getUser')
    handleSiderbarOpened();
    window.addEventListener('resize', handleSiderbarOpened)
  })

  onUnmounted(() => {
    window.removeEventListener('resize', handleSiderbarOpened)
  })

  function handleSiderbarOpened() {
    sidebarOpend.value = window.outerWidth > 768;
  }
</script>

<style scoped>


</style>