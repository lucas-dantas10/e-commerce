<template>
    <div v-if="customer.id" class="animate-fade-in-down">
        <form @submit.prevent="onSubmit()">
            <div class="bg-white px-4 pt-5 pb-4">
                <h1 class="text-2xl font-semibold pb-2">{{ title }}</h1>
                <CustomInput class="mb-2" v-model:modelInput="customer.first_name" label="Primeiro Nome" />
                <CustomInput class="mb-2" v-model:modelInput="customer.last_name" label="Último Nome" />
                <CustomInput class="mb-2" v-model:modelInput="customer.email" label="Email" />
                <CustomInput class="mb-2" v-model:modelInput="customer.phone" label="Telefone" />
                <CustomInput type="checkbox" class="mb-2" v-model:modelInput="customer.status" label="Ativo" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-xl font-semibold mt-6 pb-2 border-b border-gray-300">Endereço de Cobrança</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <CustomInput v-model:modelInput="customer.billingAddress.address1" label="Address 1" />
                            <CustomInput v-model:modelInput="customer.billingAddress.address2" label="Address 2" />
                            <CustomInput v-model:modelInput="customer.billingAddress.city" label="City" />
                            <CustomInput v-model:modelInput="customer.billingAddress.zipcode" label="Zip Code" />

                            <CustomInput type="select" :select-options="countries"
                                v-model:modelInput="customer.billingAddress.country_code" label="Country" />
                            <CustomInput v-if="!customer.billingAddress.state" v-model:modelInput="customer.billingAddress.state"
                                label="State" />
                            <CustomInput v-else type="select" :select-options="billingStateOptions"
                                v-model:modelInput="customer.billingAddress.state" label="State" />
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold mt-6 pb-2 border-b border-gray-300">Endereço de Envio</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <CustomInput v-model:modelInput="customer.shippingAddress.address1" label="Address 1" />
                            <CustomInput v-model:modelInput="customer.shippingAddress.address2" label="Address 2" />
                            <CustomInput v-model:modelInput="customer.shippingAddress.city" label="City" />
                            <CustomInput v-model:modelInput="customer.shippingAddress.zipcode" label="Zip Code" />
                            <CustomInput type="select" :select-options="countries"
                                v-model:modelInput="customer.shippingAddress.country_code" label="Country" />
                            <CustomInput v-if="!customer.shippingAddress.state" v-model:modelInput="customer.shippingAddress.state"
                                label="State" />
                            <CustomInput v-else type="select" :select-options="shippingStateOptions"
                                v-model:modelInput="customer.shippingAddress.state" label="State" />
                        </div>
                    </div>
                </div>
            </div>

            <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm
                           hover:bg-indigo-700 focus:ring-indigo-500">
                    Enviar
                </button>
                <router-link :to="{ name: 'app.customers' }" type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                    ref="cancelButtonRef">
                    Cancelar
                </router-link>
            </footer>
        </form>
    </div>
</template>

<script>
import store from '../../store';
import CustomInput from '../../components/core/CustomInput.vue';
export default {
    components: {
        CustomInput
    },

    data() {
        return {
            title: '',
            customer: '',
        }
    },

    mounted() {
        store.dispatch('getCustomer', this.$route.params.id)
            .then(({ data }) => {
                console.log(data);
                this.title = `Atualizando Cliente "${data.first_name} ${data.last_name}"`;
                this.customer = data;
            })
            .catch(({ response }) => console.log(response));

    },
}

</script>