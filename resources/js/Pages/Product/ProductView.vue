<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ToastList from '@/Components/ToastList.vue';
import { router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    quantity: {
        type: Number,
        default: 0,
    }
});

const quantityItem = ref(props.quantity);

function addCartItem() {
    router.post('/carrinho', {product_id: props.product.id});
}

function changeQuantity() {
    router.put(`/carrinho/${props.product.id}`, {
        product_id: props.product.id,
        quantity: quantityItem.value
    });
}
</script>

<template>
    <AuthenticatedLayout>
        <ToastList />
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
                            v-model="quantityItem" 
                            @change="changeQuantity()"
                            min="1"
                            class="py-1 rounded-md border-gray-200 focus:border-purple-600 focus:ring-purple-600 w-24" 
                        />
                    </div>

                    <p class="mt-6 text-gray-500">
                        <span class="font-bold text-black text-md">Descrição: </span>
                        {{ product.description }}
                    </p>

                    <div class="mt-6 w-full ">
                        <button @click.prevent="addCartItem()" class="border border-purple-600 rounded-md px-2 py-2 w-full text-xl text-center bg-purple-600 text-white ">
                            Add ao carrinho
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
