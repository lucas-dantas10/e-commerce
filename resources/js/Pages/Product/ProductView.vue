<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { onMounted } from "vue";

const props = defineProps({
    product: {
        type: Array,
        required: true,
    },
    cartItem: {
        type: Object,
    }
});

onMounted(() => console.log(props.cartItem));
</script>

<template>
    <AuthenticatedLayout>
        <section class="container mx-auto p-5">
            <div class="grid gap-6 grid-cols-1 lg:grid-cols-5">
                <div class="lg:col-span-3">
                    <div
                        class="w-full h-[240px] sm:h-[400px] flex items-center justify-center"
                    >
                        <img
                            :src="product.image"
                            :alt="product.title"
                            class="w-auto h-auto max-h-full mx-auto"
                        />
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <h2 class="text-2xl font-bold">{{ product.title }}</h2>
                    <p class="text-xl font-semibold">Preço: R$ {{ product.price }}</p>
                    <div class="flex justify-between items-center mt-6">
                        <span class="font-bold">Quantidade</span>
                        <input 
                            type="number" 
                            :v-model="cartItem == undefined ? 0 : cartItem.quantity" 
                            class="py-1 rounded-md border-gray-200 focus:border-purple-600 focus:ring-purple-600 w-24" 
                        />
                    </div>

                    <div class="mt-6 w-full ">
                        <button class="border border-purple-600 rounded-md px-2 py-2 w-full text-xl text-center bg-purple-600 text-white ">
                            Add ao carrinho
                        </button>
                    </div>

                    <p class="mt-6 text-gray-500">
                        {{ product.description }}
                    </p>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
