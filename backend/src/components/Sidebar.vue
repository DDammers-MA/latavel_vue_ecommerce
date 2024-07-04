
<template>

<div class="w-[200px] transition-all bg-indigo-700 text-white py-4 px-2">

        <router-link :to="{name: 'app.dashboard'}" class="flex items-center p-2  rounded transition-colors hover:bg-black/30">
          <span class="mr-2 ">
            <HomeIcon class="w-5"/>
          </span>
          <span>Dashboard</span>
        </router-link>

        <router-link :to="{name: 'app.products'}" class="flex items-center p-2  rounded transition-colors hover:bg-black/30">
          <span class="mr-2 ">
            <ViewListIcon class="w-5"/>
          </span>
          <span>products</span>
        </router-link>

        <router-link :to="{name: 'app.dashboard'}" class="flex items-center p-2  rounded transition-colors hover:bg-black/30">
          <span class="mr-2 ">
            <UsersIcon class="w-5"/>
          </span>
          <span>users</span>
        </router-link>

        <router-link :to="{name: 'app.dashboard'}" class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
          <span class="mr-2 ">
            <ChartBarIcon class="w-5"/>
          </span>
          <span>reports</span>
        </router-link>


    </div>

  </template>

  <script setup>
import { RouterLink } from 'vue-router';

import { HomeIcon, UsersIcon, ViewListIcon, ChartBarIcon } from '@heroicons/vue/solid';

</script>

<style scoped>


</style>