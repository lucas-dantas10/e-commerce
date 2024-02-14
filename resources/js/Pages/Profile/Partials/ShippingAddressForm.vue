<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    addressOne: '',
    addressTwo: '',
    city: '',
    cep: '',
    country: '',
    state: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Endereço de Envio</h2>

            <p class="mt-1 text-sm text-gray-600">
                Certifique-se de que sua conta esteja usando um endereço de envio.
            </p>
        </header>

        <form @submit.prevent="saveShippingAddress" class="mt-6 space-y-6">
            <div>
                <InputLabel for="address_one" value="Endereço 1" />

                <TextInput
                    id="address_one"
                    ref="currentAddressOneInput"
                    v-model="form.addressOne"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="address_one"
                />

                <InputError :message="form.errors.addressOne" class="mt-2" />
            </div>

            <div>
                <InputLabel for="address_two" value="Endereço 2" />

                <TextInput
                    id="address_two"
                    ref="addressInput"
                    v-model="form.addressTwo"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="address_two"
                />

                <InputError :message="form.errors.addressTwo" class="mt-2" />
            </div>

            <div>
                <InputLabel for="city" value="Cidade" />

                <TextInput
                    id="city"
                    v-model="form.city"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="city"
                />

                <InputError :message="form.errors.city" class="mt-2" />
            </div>

            <div>
                <InputLabel for="country" value="País" />

                <select 
                    v-model="form.country"
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                    <option value="">teste</option>
                </select>

                <!-- <TextInput
                    id="country"
                    v-model="form.country"
                    type="text"
                    max="8"
                    class="mt-1 block w-full"
                    autocomplete="country"
                /> -->

                <InputError :message="form.errors.country" class="mt-2" />
            </div>

            <div>
                <InputLabel for="state" value="Estado" />

                <select 
                    v-model="form.state"
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                    <option value="">teste</option>
                </select>

                <!-- <TextInput
                    id="state"
                    v-model="form.state"
                    type="text"
                    max="8"
                    class="mt-1 block w-full"
                    autocomplete="state"
                /> -->

                <InputError :message="form.errors.state" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Salvar</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Salvo.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
