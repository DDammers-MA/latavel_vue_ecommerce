<script setup>
import { defineProps } from 'vue';
import { Doughnut as ChartDoughnut } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, ArcElement);

const props = defineProps({
  width: {
    type: Number,
    default: 400
  },
  height: {
    type: Number,
    default: 400
  },
  data: {
    type: Object,
    required: true
  }
});

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false
};
</script>

<template>
  <div>
    <ChartDoughnut :data="props.data" :options="chartOptions" :width="props.width" :height="props.height" />
  </div>
</template>
