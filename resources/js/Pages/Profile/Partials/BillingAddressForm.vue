<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const props = defineProps({
    country: String,
    states: Array,
});

const form = useForm({
    addressOne: '',
    addressTwo: '',
    city: '',
    cep: '',
    country: '',
    state: '',
    sameShippingAddress: false,
});

const saveBillingAddress = () => {
    form.post(route('profile.billing'), {
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
            <h2 class="text-lg font-medium text-gray-900">Endereço de Cobrança</h2>

            <p class="mt-1 text-sm text-gray-600 flex items-center gap-2">
                <Checkbox :checked="form.sameShippingAddress"/>  
                <span>O mesmo endereço que o endereço de envio?</span>
            </p>
        </header>

        <form @submit.prevent="saveBillingAddress" class="mt-6 space-y-6">
            <div>
                <InputLabel for="address_one" value="Endereço 1" />

                <TextInput
                    id="address_one"
                    ref="currentAddressOneInput"
                    v-model="form.addressOne"
                    type="text"
                    class="mt-1 block w-full"
                    required
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
                    required
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
                    required
                />

                <InputError :message="form.errors.city" class="mt-2" />
            </div>

            <div>
                <InputLabel for="country" value="País" />

                <select 
                    v-model="form.country"
                    required
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                    <option :value="countries">{{ country }}</option>
                </select>

                <InputError :message="form.errors.country" class="mt-2" />
            </div>

            <div>
                <InputLabel for="state" value="Estado" />

                <select 
                    v-model="form.state"
                    required
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                    <option :value="state.sigla" v-for="state in states.states">{{ state.nome }}</option>
                </select>

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
