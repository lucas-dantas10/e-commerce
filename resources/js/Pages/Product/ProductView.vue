<script setup>
const props = defineProps({
    product: {
        type: Array,
        required: true,
    }
});
</script>

<template>
    <section class="w-full h-full flex justify-between">
        <div class="w-full h-[240px] sm:h-[400px] flex items-center justify-center">
            <img :src="product.image" :alt="product.title" class="w-auto h-auto max-h-full mx-auto">
        </div>
        <div>
            <p></p>
            <p></p>
            <div>
                <span></span>
                <input type="number">
            </div>
        </div>
    </section>
</template>