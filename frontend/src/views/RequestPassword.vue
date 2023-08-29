<template>

    <GuestLayout title="Solicitar nova senha" @submit="requestPassword">
        <div>
                <div class="mt-2">
                    <input id="email" name="email" type="email" autocomplete="email" required="" placeholder="Enderço de E-mail"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                </div>
        </div>

        <div>
            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <router-link to="/reset-password/token" class="font-semibold text-indigo-600 hover:text-indigo-500">Lembra sua senha?</router-link>
                </div>
            </div>
        </div>

        <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                <!-- <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
                </span> -->
                Solicitar
            </button>
        </div>
    </GuestLayout>
</template>

<script>
import GuestLayout from '../components/GuestLayout.vue';
export default {
    components: {
        GuestLayout
    },

    methods: {
        requestPassword() {
            console.log('requestPassword realizado');
        }
    }
}
</script>