
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
    <Spinner></Spinner> 
    </div>
    <Toast></Toast>
  </template>

  <script setup>
  import { ref, onMounted, onUnmounted, computed } from 'vue';
  import sidebar from './Sidebar.vue';
import Navbar from './Navbar.vue';
  import store from '../store';
  import Spinner from './core/Spinner.vue';
import Toast from './core/Toast.vue';

const {title} = defineProps({
 title: String
})


  const sidebarOpend = ref(true)

  const CurrentUser = computed(() => store.state.user.data);

  
  function toggleSidebar() {
 sidebarOpend.value = !sidebarOpend.value
  }

  onMounted(() => {
    store.dispatch('getCurrentUser')
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