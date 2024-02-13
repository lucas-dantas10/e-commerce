<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { onMounted } from 'vue';

const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
    orderItems: {
        type: Array,
    },
});

onMounted(() => {
    console.log(props.order)
    console.log(props.orderItems)
})
</script>

<template>
    <AuthenticatedLayout>

         <section class="w-screen h-screen p-5">
            <div class="container mx-auto lg:w-2/3" >
                <h1 class="text-4xl font-bold mb-4">Order #{{ order.id }}</h1>

                <div class="w-full h-full border rounded-md bg-white flex flex-col gap-4 p-6">
                    <div class="border-b pb-2 flex items-center gap-6">
                        <div class="flex flex-col gap-2 justify-center">
                            <h3 class="font-bold">Order #</h3>
                            <h3 class="font-bold">Order Date</h3>
                            <h3 class="font-bold">Order Status</h3>
                            <h3 class="font-bold">Sub Total</h3>
                        </div>
                        <div class="flex flex-col gap-2 justify-center">
                            <p>{{ order.id }}</p>
                            <p>{{ order.date }}</p>
                            <p 
                                class="text-white py-0 px-[1.3rem] rounded"
                                :class="order.status === 'pago' ? 'bg-emerald-500' : 'bg-gray-300'"
                            >
                                <span>{{ order.status }}</span>
                            </p>
                            <p>{{ order.subtotal }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4" v-for="(orderItem, i) in props.orderItems">
                        <div class="w-36 h-32 flex items-center justify-center overflow-hidden">
                            <img :src="orderItem.product.image" alt="">
                        </div>

                        <div class="flex flex-col justify-center gap-2">
                            <p>{{ orderItem.product.title }}</p>
                            <div class="flex items-center gap-4">
                                <label for="quantity">Quantity</label>
                                <p id="quantity" class="py-1 border-gray-200 focus:border-purple-600 focus:ring-purple-600 w-16">
                                    {{ orderItem.quantity }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </AuthenticatedLayout>
</template>