<template>
  <div>
    <label v-if="type !== 'checkbox'" :for="id" class="sr-only">{{ label }}</label>
    <div class="mt-1 flex rounded-md shadow-sm">
      <span v-if="prepend"
            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
        {{ prepend }}
      </span>

      <template v-if="type === 'textarea'">
        <textarea
          :id="id"
          :name="name"
          :required="required"
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          :class="inputClasses"
          :placeholder="label"></textarea>
      </template>

      <template v-else-if="type === 'file'">
        <input
          :id="id"
          :type="type"
          :name="name"
          :required="required"
          @change="$emit('change', $event.target.files[0])"
          :class="inputClasses"
          :placeholder="label"/>
      </template>

      <template v-else-if="type === 'select'">
        <select
          :id="id"
          :name="name"
          :required="required"
          :value="modelValue"
          @change="onChange($event.target.value)"
          :class="inputClasses">
          <option v-for="option in selectOptions" :key="option.key" :value="option.key">{{ option.text }}</option>
        </select>
      </template>

      <template v-else-if="type === 'checkbox'">
        <input
          :id="id"
          :name="name"
          :type="type"
          :checked="modelValue"
          :required="required"
          @change="$emit('update:modelValue', $event.target.checked)"
          class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"/>
        <label :for="id" class="ml-2 block text-sm text-gray-900">{{ label }}</label>
      </template>

      <template v-else>
        <input
          :id="id"
          :type="type"
          :name="name"
          :required="required"
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          :class="inputClasses"
          :placeholder="label"
          step="0.01"/>
      </template>

      <span v-if="append"
            class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
        {{ append }}
      </span>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  modelValue: [String, Number, File, Boolean],
  label: String,
  type: {
    type: String,
    default: 'text'
  },
  name: String,
  required: Boolean,
  prepend: {
    type: String,
    default: ''
  },
  append: {
    type: String,
    default: ''
  },
  selectOptions: Array,
  id: String
});

const id = computed(() => props.id || `id-${Math.floor(1000000 + Math.random() * 1000000)}`);

const inputClasses = computed(() => {
  const cls = [
    'block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm'
  ];

  if (props.prepend && !props.append) {
    cls.push('rounded-r-md');
  } else if (!props.prepend && props.append) {
    cls.push('rounded-l-md');
  } else if (!props.prepend && !props.append) {
    cls.push('rounded-md');
  }

  return cls.join(' ');
});

const emit = defineEmits(['update:modelValue', 'change']);

function onChange(value) {
  emit('update:modelValue', value)
  emit('change', value)
}
</script>
