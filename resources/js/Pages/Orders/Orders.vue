<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    orders: {
        type: Array,
        required: true
    }
});

function payOrder(id) {
    router.post(route('checkout.order', id));
}

</script>

<template>
    <AuthenticatedLayout>
        <section class="p-5">
            <div class="container mx-auto lg:w-2/3 p-5">
                <h1 class="text-2xl font-bold">Meus Pedidos</h1>
                <div class="bg-white rounded-lg mt-2 p-3 overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead>
                            <tr class="border-b-2">
                                <th class="text-left p-2">Pedido #</th>
                                <th class="text-left p-2">Data</th>
                                <th class="text-left p-2">Status</th>
                                <th class="text-left p-2">SubTotal</th>
                                <th class="text-left p-2">Items</th>
                                <th class="text-left p-2">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="border-b" v-for="(order, i) in props.orders.data" :key="i">
                                <td class="py-1 px-2">
                                    <a
                                        href="https://lcommerce.net/orders/4"
                                        class="text-purple-600 hover:text-purple-500"
                                    >
                                        #{{ order.id }}
                                    </a>
                                </td>
                                <td class="py-1 px-2 whitespace-nowrap">
                                    {{ order.date }}
                                </td>
                                <td class="py-1 px-2">
                                    <small
                                        class="text-white py-1 px-2 rounded"
                                        :class="order.status == 'pago' ? 'bg-emerald-500' : 'bg-red-500'"
                                    >
                                        {{ order.status }}
                                    </small>
                                </td>
                                <td class="py-1 px-2">{{ order.subtotal }}</td>
                                <td class="py-1 px-2 whitespace-nowrap">
                                    {{ order.quantity_items }} item(s)
                                </td>
                                <td class="py-1 px-2 flex gap-2 w-[100px]" v-if="order.status != 'pago'">
                                    <form @submit.prevent="payOrder(order.id)">
                                        <button
                                            type="submit"
                                            class="border border-purple-600 bg-purple-600 text-white flex items-center rounded-md px-2"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"
                                                ></path>
                                            </svg>
                                            Pagar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
