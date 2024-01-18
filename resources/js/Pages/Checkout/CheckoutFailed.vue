<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="p-6 mt-4 rounded-md bg-red-500 texto-white">
                <p class="text-gray-50 font-bold">Falha!! pagamento não foi realizado.</p>

                <div class="flex items-center">
                    <a :href="route('dashboard')" class="mt-6 rounded-lg bg-gray-50 px-2 py-1">
                        Voltar para home
                    </a>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>