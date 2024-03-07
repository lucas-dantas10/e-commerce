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
    router.post('/carrinho', { product_id: product.id });
}
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <ToastList />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Produtos
            </h2>
        </template>

        <div class="max-w-7xl mx-auto">
            <div>
                <div v-if="props.products.data.length == 0">
                    <div>
                        Não possui produtos
                    </div>
                </div>
                <div v-else class="flex flex-col items-center gap-8 lg:flex-row">
                    <div v-for="product in products.data" :key="product.id"
                        class="relative m-10 flex w-full max-w-xs flex-col overflow-hidden rounded-lg border border-gray-100 bg-white shadow-md">
                        <a 
                            class="relative mx-3 mt-3 flex items-center justify-center h-60 overflow-hidden rounded-xl"
                            :href="route('product.view', product.slug)"
                        >
                            <img class="object-cover" :src="product.image_url" alt="product image" />
                        </a>
                        <div class="mt-4 px-5 pb-5">
                            <a href="#">
                                <h5 class="text-xl tracking-tight text-slate-900">{{ product.title }}</h5>
                            </a>
                            <div class="mt-2 mb-5 flex items-center justify-between">
                                <p>
                                    <span class="text-3xl font-bold text-slate-900">R$ {{ product.price }}</span>
                                </p>
                            </div>
                            <button type="submit"
                                class="flex items-center justify-center rounded-md bg-slate-900 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-blue-300"
                                @click="addCartItem(product)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Add ao carrinho
                            </button>
                        </div>
                    </div>

                </div>
                <!-- <div v-else
                        class="w-3/6 flex flex-col justify-center items-center border border-1 border-gray-200 rounded-md hover:border-purple-600 transition-colors bg-white"
                        v-for="product in products.data" :key="product.id">
                        <a :href="route('product.view', product.slug)"
                            class="h-3/6 aspect-square block overflow-hidden">
                            <img class="object-cover rounded-lg hover:scale-105 hover:rotate-1 transition-transform"
                                :src="product.image_url" :alt="product.description" />
                        </a>

                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">{{ product.title }}</div>
                            <p class="text-gray-700 text-base font-bold">
                                R$ {{ product.price }}
                            </p>
                        </div>

                        <div class="px-6 py-4">
                            <button type="submit"
                                class="border px-4 py-2 rounded-md bg-purple-600 text-white hover:bg-purple-500 transition-colors"
                                @click="addCartItem(product)">
                                Add ao carrinho
                            </button>
                        </div>
                    </div> -->
            </div>

            <Pagination :pagination="products.meta" />
        </div>



    </AuthenticatedLayout>
</template>
