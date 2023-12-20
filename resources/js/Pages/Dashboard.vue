<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { onMounted } from "vue";
import Pagination from "@/Components/Pagination.vue";

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
        <div class="grid gap-8 grig-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 p-5">
            <div 
                class="border border-1 border-gray-200 rounded-md hover:border-purple-600 transition-colors bg-white"               
                v-for="product in products.data" 
                :key="product.id"
            >
                <a href="#" class="aspect-square block overflow-hidden">
                    <img
                        class="object-cover rounded-lg hover:scale-105 hover:rotate-1 transition-transform"
                        :src="product.image_url"
                        alt="Sunset in the mountains"
                    />
                </a>
                
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">{{ product.title }}</div>
                    <p class="text-gray-700 text-base font-bold">
                        R$ {{ product.price }}
                    </p>
                </div>

                <div class="px-6 py-4">
                    <button 
                        class="border px-4 py-2 rounded-md bg-purple-600 text-white hover:bg-purple-500 transition-colors"
                    >
                        Add ao carrinho
                    </button>
                </div>
            </div>
        </div>

        <Pagination :pagination="products.meta" />
    </AuthenticatedLayout>
</template>
