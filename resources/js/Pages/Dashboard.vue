<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import ToastList from '../Components/ToastList.vue';
import { ref, onMounted } from "vue";

const error = ref({});
const props = defineProps({
    products: {
        type: Object,
        required: true
    }
});
function addCartItem(product) {
    router.post('/carrinho', {product_id: product.id});
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <ToastList />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Home
            </h2>
        </template>
        <div class="grid gap-8 grig-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 p-5">

            <div v-if="props.products.data.length == 0" >
                <div>
                    Não possui produtos
                </div>
            </div>
            <div
                v-else
                class="border border-1 border-gray-200 rounded-md hover:border-purple-600 transition-colors bg-white"               
                v-for="product in products.data" 
                :key="product.id"
            >
                <a :href="route('product.view', product.slug)" class="aspect-square block overflow-hidden">
                    <img
                        class="object-cover rounded-lg hover:scale-105 hover:rotate-1 transition-transform"
                        :src="product.image_url"
                        :alt="product.description"
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
                        type="submit"
                        class="border px-4 py-2 rounded-md bg-purple-600 text-white hover:bg-purple-500 transition-colors"
                        @click="addCartItem(product)"
                    >
                        Add ao carrinho
                    </button>
                </div>
            </div>
        </div>

        <Pagination :pagination="products.meta" />
    </AuthenticatedLayout>
</template>
