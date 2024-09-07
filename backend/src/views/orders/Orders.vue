<template>
 
  <div class="flex items-center justify-between mb-3">
  <h1 class="text-3xl font-semibold">Orders</h1>

  </div>
  
  <OrdersTable @clickView="viewP"></OrdersTable>
 
    </template>
    
    <script setup>

  import { computed, onMounted, ref } from 'vue';

import OrdersTable from './OrdersTable.vue';
import store from "../../store";

const orders = computed(() => store.state.orders);


    function showOrder(p) {
    
    }
  
  
  
  
  
    </script>
    
    <style scoped>
  
    </style>
    