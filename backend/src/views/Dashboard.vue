<template>
   <h1 class="text-4xl mb-3">Dashboard</h1>
<div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">


<div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
  <label class="font-semibold text-lg" for="">Active Customers</label>
  <template v-if="!loading.customersCount">

  <span class="text-3xl font-semibold">
    {{ customersCount }}
  </span>

  </template>
  <Spinner v-else text=""></Spinner>

  
</div>

<div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
  <label class="font-semibold text-lg" for="">Active Products</label>
  <template v-if="!loading.productsCount">

<span class="text-3xl font-semibold">
  {{ productsCount }}
</span>

</template>
<Spinner v-else text=""></Spinner>


</div>
<div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
  <label class="font-semibold text-lg" for="">Paid Orders</label>
  <template v-if="!loading.paidOrders">

<span class="text-3xl font-semibold">
  {{ paidOrders }}
</span>

</template>
<Spinner v-else text=""></Spinner>

</div>
<div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center ">
  <label class="font-semibold text-lg" for="">Total Income</label>
  <template v-if="!loading.totalIncome">

<span class="text-3xl font-semibold">
  {{ totalIncome }}
</span>

</template>
<Spinner v-else text=""></Spinner>

</div>

</div>


<div class="grid grid-rows-2 grid-flow-col grid-cols-1 md:grid-cols-3 gap-4">

  <div class=" col-span-2 row-span-3 bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
  Products
</div>

<div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
      <label class="font-semibold text-lg">Orders by countries</label>
      <template v-if="!loading.totalIncome">
        <Doughnut :width="140" :height="200"  :data="chartData" />
      </template>
      <Spinner v-else text=""></Spinner>

    </div>

    <div class="bg-white py-6 px-5 rounded-lg shadow ">
    
      <label class="font-semibold text-lg block mb-3">Orders by countries</label>
      <router-link to="/" v-for="c of latesCustomer" :key="c.id" class=" mb-4 flex items-center hover:cursor-pointer hover:bg-gray-100 hover:rounded-md">
        <div class="w-8 h-8 bg-gray-200 flex items-center justify-center rounded-full mr-2">
          <UserIcon class="w-5" />
        </div>
        <div>
          <h3>{{ c.first_name }} {{ c.last_name }}</h3>
          <p>{{ c.email }}</p></div>

      </router-link>
    </div>

</div>

  </template>
  
<script setup>
import { ref, onMounted } from 'vue';
import axiosClient from '../axios';
import Doughnut from '../components/core/Chart/Doughnut.vue';
import Spinner from '../components/core/Spinner.vue';
import { UserIcon } from '@heroicons/vue/solid';

const loading = ref({
  customersCount: true,
  productsCount: true,
  paidOrders: true,
  totalIncome: true,
  ordersByCountry: true
});

const customersCount = ref(0);
const productsCount = ref(0);
const paidOrders = ref(0);
const totalIncome = ref(0);
const latesCustomer = ref(0);


const chartData = ref({
  labels: [],
  datasets: [{
    backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
    data: []
  }]
});

onMounted(() => {
  axiosClient.get('/dashboard/customers-count').then(({ data }) => {
    customersCount.value = data;
    loading.value.customersCount = false;
  });

  axiosClient.get('/dashboard/products-count').then(({ data }) => {
    productsCount.value = data;
    loading.value.productsCount = false;
  });

  axiosClient.get('/dashboard/orders-count').then(({ data }) => {
    paidOrders.value = data;
    loading.value.paidOrders = false;
  });



  axiosClient.get('/dashboard/income-amount').then(({ data }) => {
    totalIncome.value = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'EUR',
      minimumFractionDigits: 0
    }).format(data);
    loading.value.totalIncome = false;
  });

  axiosClient.get('/dashboard/orders-by-country').then(({ data: countries }) => {
    const labels = [];
    const dataValues = [];
    
    countries.forEach(c => {
      labels.push(c.name);
      dataValues.push(c.count);
    });

    chartData.value = {
      labels: labels,
      datasets: [{
        backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
        data: dataValues
      }]
    };
    loading.value.ordersByCountry = false;
    console.log(chartData.value);

  });

  axiosClient.get('/dashboard/latest-customers').then(({ data: customers }) => {
    latesCustomer.value = customers;
    loading.value.latesCustomer = false;
  });

});
</script>

  
  <style scoped>
  
  </style>
  