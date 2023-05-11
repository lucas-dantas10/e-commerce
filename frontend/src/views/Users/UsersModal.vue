<template>
    <div>
        <h1>oi</h1>
    </div>
</template>

<script>
import { computed } from 'vue';

export default {
    props: {
        modelValue: Boolean,
        products: {
            type: Object,
            required: true
        }
    },

    emits: ['update:modelValue', 'close'],

    setup(props, { emit }) {
        const show = computed({
            get: () => props.modelValue,
            set: (value) => emit('update:modelValue', value)
        });

        return {
            show 
        }
    }
}
</script>