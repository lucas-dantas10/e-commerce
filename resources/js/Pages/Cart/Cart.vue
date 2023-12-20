<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onUpdated } from 'vue';
import { onMounted } from 'vue';

const props = defineProps({
    cartItems: {
        type: Array,
    },
    products: {
        type: Array,
    }
});

onMounted(() => {
    console.log(props.cartItems[0].product);
})
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Seus items do carrinho</h2>

            <div class="w-full h-full border bg-gray-200 rounded-md p-4 mt-4">
                <div v-for="cartItem in cartItems">
                    <div class="w-full flex flex-col sm:flex-row items-center gap-4 flex-1 p-4">
                        <a class="w-36 h-32 flex items-center justify-center overflow-hidden">
                            <img :src="cartItem.product.image" class="object-cover" :alt="cartItem.product.description">
                        </a>
                        <div class="flex flex-col justify-between flex-1 gap-6">

                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold">{{ cartItem.product.title }}</h3>
                                <p class="font-bold">{{ cartItem.product.title }}</p>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="flex items-center gap-2">
                                        Quantidade:
                                        <input v-model="cartItem.quantity" type="number" min="1" class="py-1 border-gray-200 focus:border-purple-600 focus:ring-purple-600 w-16"> 
                                    </span>
                                </div>
                                <a href="">Remover</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-300 pt-4">
                    <div class="p-4 flex flex-col gap-6">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold">Subtotal</span>
                            <span class="font-bold">{{ cartItems[0].product.price }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="text-gray-500">Frete e impostos calculados na finalização da compra.</p>
                        </div>
                    </div>

                    <div class="p-4 flex items-center justify-center">
                        <button type="submit" class="border py-2 border-purple-700 bg-purple-700 text-white text-xl text-center w-[50%] rounded-md">
                            Finalizar Compra
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>