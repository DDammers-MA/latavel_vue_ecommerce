<template>
  <div class="mb-3 flex items-center justify-between ">
    <h1 class="text-3xl font-semibold">Dashboard</h1>
<div class="flex items-center">
  <label class="mr-2" for="">Change Date Period</label>
  <CustomInput type="select" v-model="chosenDate" @change="onDatePickerChange" :select-options="dateOptions"></CustomInput>
</div>

  </div>
 
<div  class="  grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">


<div class=" animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
  <label class="font-semibold text-lg" for="">Active Customers</label>
  <template v-if="!loading.customersCount">

  <span class="text-3xl font-semibold">
    {{ customersCount }}
  </span>

  </template>
  <Spinner v-else text=""></Spinner>

  
</div>

<div class=" animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center"  style="animation-delay: 0.1s;">
  <label class="font-semibold text-lg" for="">Active Products</label>
  <template v-if="!loading.productsCount">

<span class="text-3xl font-semibold">
  {{ productsCount }}
</span>

</template>
<Spinner v-else text=""></Spinner>


</div>
<div class=" animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center"  style="animation-delay: 0.2s;">
  <label class="font-semibold text-lg" for="">Paid Orders</label>
  <template v-if="!loading.paidOrders">

<span class="text-3xl font-semibold">
  {{ paidOrders }}
</span>

</template>
<Spinner v-else text=""></Spinner>

</div>

<div class=" animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center "  style="animation-delay: 0.3s;">
  <label class="font-semibold text-lg" for="">Total Income</label>
  <template v-if="!loading.totalIncome">

<span class="text-3xl font-semibold">
  {{ totalIncome  }}
</span>

</template>
<Spinner v-else text=""></Spinner>

</div>

</div>


<div class="grid grid-rows-1 md:grid-rows-2 md:grid-flow-col grid-cols-1 md:grid-cols-3 gap-4">

  <div class=" animate-fade-in-down col-span-1 md:col-span-2 md:col-span-2 row-span-1 md:row-span-2 bg-white py-6 px-5 rounded-lg shadow">
      <label class="text-lg font-semibold block mb-2">Latest Orders</label>
      <template v-if="!loading.latestOrder">
        <div v-for="o of latestOrder" :key="o.id" class="py-2 px-3 hover:bg-gray-50">
          <p>
            <router-link :to="{name: 'app.orders.view', params: {id: o.id}}" class="text-indigo-700 font-semibold">
              Order #{{ o.id }}
            </router-link>
            created {{ o.created_at }}. {{ o.items }} items
          </p>
          <p class="flex justify-between">
            <span>{{ o.first_name }} {{ o.last_name }}</span>
            <span>{{$filters.currencyEUR(o.total_price)  }}</span>
          </p>
        </div>
      </template>
      <Spinner v-else text="" class=""/>
    </div>

<div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center" style="animation-delay: 0.1s;">
      <label class="font-semibold text-lg">Orders by countries</label>
      <template v-if="!loading.totalIncome">
        <Doughnut :width="140" :height="200"  :data="chartData" />
      </template>
      <Spinner v-else text=""></Spinner>

    </div>

    <div class=" animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow " style="animation-delay: 0.1s;">
    
      <label class="font-semibold text-lg block mb-3">latest customers</label>
       <template v-if="!loading.latesCustomer">
      <router-link :to="{name: 'app.customers.view', params: {id: c.id}}" v-for="c of latesCustomer" :key="c.id" class=" mb-4 flex items-center hover:cursor-pointer hover:bg-gray-100 hover:rounded-md">
        <div class="w-8 h-8 bg-gray-200 flex items-center justify-center rounded-full mr-2">
          <UserIcon class="w-5" />
        </div>
        <div>
          <h3>{{ c.first_name }} {{ c.last_name }}</h3>
          <p>{{ c.email }}</p></div>

      </router-link>
      </template>
            <Spinner v-else text=""></Spinner>
    </div>

</div>

  </template>
  
<script setup>
import { ref, onMounted } from 'vue';
import axiosClient from '../axios';
import Doughnut from '../components/core/Chart/Doughnut.vue';
import Spinner from '../components/core/Spinner.vue';
import { UserIcon } from '@heroicons/vue/solid';
import CustomInput from '../components/core/CustomInput.vue';

const loading = ref({
  customersCount: true,
  productsCount: true,
  paidOrders: true,
  totalIncome: true,
  ordersByCountry: true,
  latesCustomer: true,
  latestOrder: true
});

const dateOptions = ref([
{key: '2d', text: 'Last Day'},
{key: '1w', text: 'Last week'},
{key: '2w', text: 'Last 2 weeks'},
{key: '1m', text: 'Last month'},
{key: '3m', text: 'Last 3 months'},
{key: '6m', text: 'Last 6 months'},
{key: 'all', text: 'All time'},
]) 

const chosenDate = ref('all')

const customersCount = ref(0);
const productsCount = ref(0);
const paidOrders = ref(0);
const totalIncome = ref(0);
const latesCustomer = ref(0);
const latestOrder = ref(0);


const chartData = ref({
  labels: [],
  datasets: [{
    backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
    data: []
  }]
});


 



function updateDashboard() {

  const d = chosenDate.value

  loading.value= {
    customersCount: true,
  productsCount: true,
  paidOrders: true,
  totalIncome: true,
  ordersByCountry: true,
  latesCustomer: true,
  latestOrder: true
  }
  
  axiosClient.get('/dashboard/customers-count', {params: {d}}).then(({ data }) => {
    customersCount.value = data;
    loading.value.customersCount = false;
  });

  axiosClient.get('/dashboard/products-count', {params: {d}}).then(({ data }) => {
    productsCount.value = data;
    loading.value.productsCount = false;
  });

  axiosClient.get('/dashboard/orders-count', {params: {d}}).then(({ data }) => {
    paidOrders.value = data;
    loading.value.paidOrders = false;
  });



  axiosClient.get('/dashboard/income-amount', {params: {d}}).then(({ data }) => {
    totalIncome.value = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'EUR',
      minimumFractionDigits: 0
    }).format(data);
    loading.value.totalIncome = false;
  });

  axiosClient.get('/dashboard/orders-by-country', {params: {d}}).then(({ data: countries }) => {
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

  axiosClient.get('/dashboard/latest-customers', {params: {d}}).then(({ data: customers }) => {
    latesCustomer.value = customers;
    loading.value.latesCustomer = false;
  });


  axiosClient.get('/dashboard/latest-orders', {params: {d}}).then(({ data: orders }) => {
    latestOrder.value = orders.data;
    loading.value.latestOrder = false;
  });
}

function onDatePickerChange() {
updateDashboard()
}

onMounted(()=> updateDashboard())
</script>

  
  <style scoped>
  
  </style>
  