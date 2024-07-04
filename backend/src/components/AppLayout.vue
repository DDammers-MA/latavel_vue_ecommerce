
<template>

    <div class="min-h-full bg-gray-200 flex ">
      <!-- siderbar -->
     <sidebar :class="{'-ml-[200px]': !sidebarOpend}"/>

   <!-- siderbar -->
    <div class="flex-1">
  <Navbar @toggle-sidebar="toggleSidebar"></Navbar>
    
    <!-- content -->
    <main class="p-6">
     <div class="p-4 rounded bg-white">
      <router-view></router-view>
     </div>
    </main>

        <!-- content -->
    </div>
    </div>
  </template>

  <script setup>
  import { ref, onMounted, onUnmounted } from 'vue';
  import sidebar from './Sidebar.vue';
import Navbar from './Navbar.vue';
const {title} = defineProps({
 title: String
})

const sidebarOpend = ref(true)

  function toggleSidebar() {
 sidebarOpend.value = !sidebarOpend.value
  }

  onMounted(() => {
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