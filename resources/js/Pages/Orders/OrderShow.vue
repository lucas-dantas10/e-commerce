<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { onMounted } from 'vue';

const props = defineProps({
    order: {
        type: Object,
        required: true,
    }
});

onMounted(() => {
    console.log(props.order)
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
                            <h3>{{ order.id }}</h3>
                            <h3>{{ order.created_at }}</h3>
                            <h3>{{ order.status }}</h3>
                            <h3>R$ {{ order.total_price }}</h3>
                        </div>
                        <!-- <div class="flex items-center gap-4">
                            <h3>Order#</h3>
                            <p>{{ order.id }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <h3>Order Date</h3>
                            <p>{{ order.created_at }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <h3>Order Status</h3>
                            <p>{{ order.status }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <h3>Sub Total</h3>
                            <p>{{ order.amount }}</p>
                        </div> -->
                    </div>

                    <div>
                        <p>IMAGEM</p>
                    </div>
                </div>
            </div>
        </section>

    </AuthenticatedLayout>
</template>