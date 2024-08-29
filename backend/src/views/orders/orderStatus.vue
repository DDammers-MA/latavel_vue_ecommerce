<template>

<span class="text-white py-1 px-2 rounded" :class="{
  'bg-emerald-500': ['Paid', 'completed'].includes(order.status),
  'bg-blue-500': order.status === 'shipped',
      'bg-red-500': order.status === 'Unpaid',
      'bg-gray-400': order.status === 'cancelled',
    }">{{order.status}}</span>

</template>

<script setup>
const { order } = defineProps({
     order: Object
})
</script>