<template>
   <h1 class="text-4xl mb-3">Dashboard</h1>
<div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">


<div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
  <label for="">Active Customers</label>
  <span class="text-3xl font-semibold">

  </span>
  
</div>

<div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
  <label for="">Active Products</label>
  <span class="text-3xl font-semibold">28</span>
  
</div>
<div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
  <label for="">Paid Orders</label>
  <span class="text-3xl font-semibold">

  </span>
  
</div>
<div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center ">
  <label for="">Total Income</label>
  <span class="text-3xl font-semibold">$20,909</span>
  
</div>

</div>


<div class="grid grid-rows-2 grid-flow-col grid-cols-1 md:grid-cols-3 gap-4">

  <div class=" col-span-2 row-span-3 bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
  Products
</div>

<div class=" bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
  <Doughnut :width="140" :height="200"></Doughnut>
</div>
<div class=" bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
  Customers
</div>

</div>

  </template>
  
  <script setup>
import Doughnut from '../components/core/Chart/Doughnut.vue';


  </script>
  
  <style scoped>
  .dashboard {
    padding: 20px;
  }
  </style>
  