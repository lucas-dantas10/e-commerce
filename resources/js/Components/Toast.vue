<template>
    <div
        v-show="toast.show"
        class="fixed w-[400px] z-10 left-[85%] -ml-[200px] top-2 py-2 px-4 pb-4 opacity-80 text-white"
        :class="{
            'bg-emerald-500': toast.type == 'success',
            'bg-red-500': toast.type == 'error'
        }"
    >
        <div class="font-semibold">{{ toast.message }}</div>
        <button
            @click="close"
            class="absolute flex items-center justify-center right-2 top-2 w-[30px] h-[30px] rounded-full hover:bg-black/10 transition-colors"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>
        </button>
        <!-- Progress -->
        <div>
            <div
                class="absolute left-0 bottom-0 right-0 h-[6px] bg-black/10"
                :style="{ width: `${percent}%` }"
            ></div>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
import {  onUpdated, ref, watch } from "vue";

let interval = null;
let timeout = null;
const props = defineProps({
    toast: {
        type: Object
    }
})

const percent = ref(0);

onUpdated(() => {
    console.log(toast)
    toastRef.value = {
        type: toast.type,
        message: toast.message,
        show: true,
        delay: 3000
    }
});

const toastRef = ref({
    type: 'success',
    message: 'Teste',
    show: true,
    delay: 3000
});

watch(toastRef.value, (newToast) => {
    if (newToast.show) {
        if (interval) {
            clearInterval(interval);
            interval = null;
        }
        if (timeout) {
            clearTimeout(timeout);
            timeout = null;
        }

        timeout = setTimeout(() => {
            close();
            timeout = null;
        }, toast.value.delay);
        const startDate = Date.now();
        const futureDate = Date.now() + toast.value.delay;
        interval = setInterval(() => {
            const date = Date.now();
            percent.value =
                ((date - startDate) * 100) / (futureDate - startDate);
            if (percent.value >= 100) {
                clearInterval(interval);
                interval = null;
            }
        }, 30);
    }
});

// function close() {
//     store.commit("hideToast");
// }
</script>
