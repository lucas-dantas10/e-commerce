<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { onMounted } from "vue";

const props = defineProps({
    customer: Object
});

onMounted(() => console.log(props.customer))
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="p-6 mt-4 rounded-md bg-emerald-500 texto-white">
                <p class="text-gray-50 font-bold">Sucesso!! {{ props.customer.name }}, Seu pedido foi completado!</p>

                <div class="flex items-center">
                    <a :href="route('dashboard')" class="mt-6 rounded-lg bg-gray-50 px-2 py-1">
                        Voltar para home
                    </a>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>