<template>
    <GuestLayout title="Entre com a sua conta" @submit="login">

        <div v-if="errorMsg" class="flex items-center justify-between py-3 px-5 bg-red-500 text-white rounded">
            {{ errorMsg }}

            <span @click="error"
                class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </span>
        </div>


        <input type="hidden" name="remember" value="true">
        <div>
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Endereço de E-mail</label>
            <div class="mt-2">
                <input v-model.trim="user.email" id="email" name="email" type="email" autocomplete="email" required=""
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Senha</label>
            </div>
            <div class="mt-2">
                <input v-model.trim="user.password" id="password" name="password" type="password" autocomplete="current-password" required=""
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember-me" name="remember-me" type="checkbox" v-model="user.remember"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"/>
                <label for="remember-me" class="ml-2 block text-sm text-gray-900"> Lembrar de mim </label>
            </div>

            <div class="text-sm">
                    <router-link :to="{name: 'requestPassword'}" class="font-semibold text-indigo-600 hover:text-indigo-500">
                        Esqueceu a senha?
                    </router-link>
            </div>
        </div>


        <div>
            <button 
                type="submit"
                :disabled="loading"
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                :class="{
                  'cursor-not-allowed': loading,
                  'hover:bg-indigo-500': loading,
                }"
            >
                <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>


                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
                </span>
                Entrar
            </button>
        </div>
    </GuestLayout>
</template>

<script>
import GuestLayout from '../components/GuestLayout.vue';
import { LockClosedIcon } from '@heroicons/vue/24/solid';
import store from "../store";
import router from "../router/index.js";
export default {
    components: {
        GuestLayout,
        LockClosedIcon
    },

    data() {
        return {
            user: {
                email: '',
                password: '',
                remember: false
            },
            errorMsg: '',
            loading: false
        }
    },

    methods: {
        login() {
            this.loading = true;

            store.dispatch('login', this.user)
            .then(() => {
                router.push({name: 'app.dashboard'});
            })
            .catch((response) => {
                console.log(response);
                this.errorMsg = response.response.data.message;
            })
            .finally(() => this.loading = false);
        },

        error() {
            this.errorMsg = '';
        }
    }
}
</script>