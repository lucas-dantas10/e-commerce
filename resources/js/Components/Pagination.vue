<script setup>
import { Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
    pagination: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="w-full h-full flex justify-between items-center">
        <div>
            <p class="text-gray-500">
                Mostrando {{ pagination.to }} de {{ pagination.total }}
            </p>
        </div>

        <nav class="relative flex justify-center">
            <template v-for="link in pagination.links" :key="link.label">
                <Link 
                    preserve-scroll
                    :href="link.url ?? ''" 
                    v-html="link.label" 
                    class="flex items-center justify-center px-3 py-2 text-sm rounded-lg text-gray-600"
                    :class="{'bg-gray-200': link.active, '!text-gray-400': !link.url}"
                />
            </template>
        </nav>
    </div>
</template>
