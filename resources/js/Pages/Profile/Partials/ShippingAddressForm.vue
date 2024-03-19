<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';

const countryShippingValue = ref('');
const address1Input = ref(null);

const props = defineProps({
    countries: Array,
    countryShipping: Object,
    address: Object
});

const form = useForm({
    address1: '',
    address2: '',
    city: '',
    zipcode: '',
    country_code: '',
    state: '',
});

const shippingStateOptions = computed(() => {
    if (!countryShippingValue.value || !countryShippingValue.value.states) return [];

    const states = JSON.parse(countryShippingValue.value.states);
    return Object.entries(states).map(c => ({abbreviation: c[0], name: c[1]}));
})

onMounted(() => {
    form.address1 = props.address.address1;
    form.address2 = props.address.address2;
    form.city = props.address.city;
    form.zipcode = props.address.zipcode;
    form.country_code = props.countryShipping.code;
    form.state = props.address.state;
    countryShippingValue.value = {
        'code': props.countryShipping.code,
        'name': props.countryShipping.name,
        'states': props.countryShipping.states,
    };
});

const saveShippingAddress = () => {
    form.post(route('profile.shipping'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.address1) {
                form.reset('address1');
                address1Input.value.focus();
            }
        },
    });
};

function changeStates(countryCode) {
    countryShippingValue.value.states = props.countries.find(c => c.code == countryCode).states;
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Endereço de Envio</h2>

            <p class="mt-1 text-sm text-gray-600">
                Certifique-se de que sua conta esteja usando um endereço de envio e endereço de cobraça.
            </p>
        </header>

        <form @submit.prevent="saveShippingAddress" class="mt-6 space-y-6">
            <div>
                <InputLabel for="address_one" value="Endereço 1" />

                <TextInput
                    id="address_one"
                    ref="address1Input"
                    v-model="form.address1"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="address_one"
                    required
                />

                <InputError :message="form.errors.address1" class="mt-2" />
            </div>

            <div>
                <InputLabel for="address_two" value="Endereço 2" />

                <TextInput
                    id="address_two"
                    ref="addressInput"
                    v-model="form.address2"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="address_two"
                    required
                />

                <InputError :message="form.errors.address2" class="mt-2" />
            </div>

            <div>
                <InputLabel for="zipcode" value="CEP" />

                <TextInput
                    id="zipcode"
                    ref="addressInput"
                    v-model.trim="form.zipcode"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="zipcode"
                    required
                />

                <InputError :message="form.errors.zipcode" class="mt-2" />
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
                    v-model="form.country_code"
                    required
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    @change="changeStates(form.country_code)"
                >
                    <option 
                        v-for="(country, i) in props.countries" 
                        :key="i" 
                        :selected="country.name == countryShippingValue.name" 
                        :disabled="country.name == countryShippingValue.name" 
                        :value="country.code">
                        {{ country.name }}
                    </option>
                </select>

                <InputError :message="form.errors.country_code" class="mt-2" />
            </div>

            <div>
                <InputLabel for="state" value="Estado" />

                <select 
                    v-model="form.state"
                    required
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                    <option  
                        v-for="(state, i) in shippingStateOptions" 
                        :key="i" 
                        :selected="state.name == props.address.state" 
                        :disabled="state.name == props.address.state" 
                        :value="state.name">{{ state.name }}
                    </option>
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
