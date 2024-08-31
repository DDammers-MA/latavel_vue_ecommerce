
<template>
  
  <h1 class="text-4xl mb-3">Dashboard</h1>
  <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
    <div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
      <label>Active Customers</label>
      <template v-if="!loading.customersCount">
        <span class="text-3xl font-semibold">{{ customersCount }}</span>
      </template>
      <Spinner v-else text=""></Spinner>
    </div>
    <div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
      <label>Active Products</label>
      <template v-if="!loading.productsCount">
        <span class="text-3xl font-semibold">{{ productsCount }}</span>
      </template>
      <Spinner v-else text=""></Spinner>
    </div>
    <div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
      <label>Paid Orders</label>
      <template v-if="!loading.paidOrders">
        <span class="text-3xl font-semibold">{{ paidOrders }}</span>
      </template>
      <Spinner v-else text=""></Spinner>
    </div>
    <div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center">
      <label>Total Income</label>
      <template v-if="!loading.totalIncome">
        <span class="text-3xl font-semibold">{{ totalIncome }}</span>
      </template>
      <Spinner v-else text=""></Spinner>
    </div>
  </div>

  
  <div class="grid grid-rows-2 grid-flow-col grid-cols-1 md:grid-cols-3 gap-4">
    <div class="col-span-2 row-span-3 bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
      Products
    </div>

    <div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
      <label>Orders by countries</label>
      <template v-if="!loading.totalIncome">
        <Doughnut :width="140" :height="200"  :data="chartData" :options="{ responsive: false, maintainAspectRatio: false }"/>
      </template>
      <Spinner v-else text=""></Spinner>

    </div>
    <div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
      {{latesCustomer}}
      <div v-for="c of latesCustomer" :key="c.user_id">
        <h3>{{ c.first_name }} {{ c.last_name }}</h3>
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import axiosClient from '../axios';
import { Doughnut } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from 'chart.js';
import Spinner from '../components/core/Spinner.vue';

ChartJS.register(Title, Tooltip, Legend, ArcElement);

// Reactive state
const loading = ref({
  customersCount: true,
  productsCount: true,
  paidOrders: true,
  totalIncome: true,
  ordersByCountry: true,
  latesCustomer: true
});
const customersCount = ref(0);
const productsCount = ref(0);
const paidOrders = ref(0);
const totalIncome = ref(0);
const latesCustomer = ref(0);
const chartData = ref({ labels: [], datasets: [{ backgroundColor: [], data: [] }] });

// Fetch data
onMounted(async () => {
  try {
    const { data: customers } = await axiosClient.get('/dashboard/customers-count');
    customersCount.value = customers;
    loading.value.customersCount = false;

    const { data: products } = await axiosClient.get('/dashboard/products-count');
    productsCount.value = products;
    loading.value.productsCount = false;

    const { data: orders } = await axiosClient.get('/dashboard/orders-count');
    paidOrders.value = orders;
    loading.value.paidOrders = false;

    const { data: latesCustomer } = await axiosClient.get('/dashboard/latest-customers');
    latesCustomer.value = customers;
    loading.value.latesCustomer = false;


    const { data: income } = await axiosClient.get('/dashboard/income-amount');
    totalIncome.value = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'EUR',
      minimumFractionDigits: 0
    }).format(income);
    loading.value.totalIncome = false;

    const { data: countries } = await axiosClient.get('/dashboard/orders-by-country');
    chartData.value = {
      labels: countries.map(c => c.name),
      datasets: [{
        backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
        data: countries.map(c => c.count)
      }]
    };
    loading.value.ordersByCountry = false;
  } catch (error) {
    console.error('Error fetching data:', error);
  }
});
</script>


<style scoped>
/* Your scoped styles here */
</style>
