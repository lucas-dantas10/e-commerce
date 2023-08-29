<template>
    <GuestLayout title="Definir nova senha" @submit="newPassword">
        <div>
            <div class="mt-2">
                <input id="password" name="password" type="password" autocomplete="password" required="" placeholder="Nova senha"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>

            <div class="mt-2">
                <input id="repeatPassword" name="repeatPassword" type="password" autocomplete="repeatPassword" required="" placeholder="Repita a nova senha"
                    class="block w-full rounded-md border-0 px-2.5 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <router-link to="/login" class="font-semibold text-indigo-600 hover:text-indigo-500">Volte para o Login</router-link>
                </div>
            </div>
        </div>

        <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Definir
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
        newPassword() {
            console.log('nova senha realizado');
        }
    }
}
</script>