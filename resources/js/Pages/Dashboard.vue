<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { onMounted } from "vue";

const props = defineProps({
    products: {
        type: Object,
        required: true
    }
});

onMounted(() => {
    console.log(props.products);
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Home
            </h2>
        </template>

        <div class="max-w-sm rounded overflow-hidden py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" v-for="product in products" :key="product.id">
                <img
                    class="w-full"
                    :src="product.image"
                    alt="Sunset in the mountains"
                />
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">{{ product.title }}</div>
                    <p class="text-gray-700 text-base">
                        Preço: {{ product.price }}
                    </p>
                </div>
                <div class="px-6 pt-4 pb-2">
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
                        >#photography</span
                    >
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
                        >#travel</span
                    >
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
                        >#winter</span
                    >
                </div>
            </div>
        </div>

        <!-- <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div> -->
    </AuthenticatedLayout>
</template>
