<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { computed } from "vue";
import { router } from '@inertiajs/vue3';

const props = defineProps({
    cartItems: {
        type: Array,
    },
    products: {
        type: Array,
    },

    total: {
        type: Number
    }
});

function changeQuantity(cart) {
    router.put(`/carrinho/${cart.product_id}`, cart);
}

function removeProductOfCart(cartItem) {
    router.delete(`/carrinho/${cartItem.product_id}`);
}

function checkout() {
    router.post(route('cart.checkout'));
}

const getTotalValue = computed(() => {
    return props.total;
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Seus items do carrinho
            </h2>

            <div class="w-full h-full border bg-gray-200 rounded-md p-4 mt-4" v-if="cartItems.length == 0">
                <div>
                    <div class="w-full flex flex-col sm:flex-row items-center gap-4 flex-1 p-4" >
                        <p>Você não tem items no carrinho</p>
                    </div>
                </div>
            </div>

            <div v-else class="w-full h-full border bg-gray-200 rounded-md p-4 mt-4">
                <div v-for="product in products" class="border-b border-gray-300">
                    <div
                        class="w-full flex flex-col sm:flex-row items-center gap-4 flex-1 p-4"
                    >
                        <a
                            :href="route('product.view', product.slug)"
                            class="w-36 h-32 flex items-center justify-center overflow-hidden"
                        >
                            <img
                                :src="product.image"
                                class="object-cover"
                                :alt="product.description"
                            />
                        </a>
                        <div class="flex flex-col justify-between flex-1 gap-6">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold">
                                    {{ product.title }}
                                </h3>
                                <p class="font-bold">{{ product.title }}</p>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="flex items-center gap-2">
                                        Quantidade:
                                        <input
                                            v-model="
                                                cartItems[product.id].quantity
                                            "
                                            @change="changeQuantity(cartItems[product.id])"
                                            type="number"
                                            min="1"
                                            class="py-1 border-gray-200 focus:border-purple-600 focus:ring-purple-600 w-16"
                                        />
                                    </span>
                                </div>
                                <a href="#" class="text-blue-400" @click.prevent="removeProductOfCart(cartItems[product.id])">Remover</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-300 pt-4">
                    <div class="p-4 flex flex-col gap-6">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold">Subtotal</span>
                            <span class="font-bold">{{ getTotalValue }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="text-gray-500">
                                Frete e impostos calculados na finalização da
                                compra.
                            </p>
                        </div>
                    </div>

                    <div class="p-4 flex items-center justify-center">
                        
                        <button
                            type="submit"
                            @click="checkout()"
                            class="border py-2 border-purple-700 bg-purple-700 text-white text-xl text-center w-[50%] rounded-md"
                        >
                            Finalizar Compra
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>
