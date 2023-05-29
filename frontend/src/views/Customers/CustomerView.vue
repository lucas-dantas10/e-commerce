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
            </div>

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
                this.title = `Atualizando Cliente "${data.first_name} ${data.last_name}"`;
                this.customer = data;
            })
            .catch(({ response }) => console.log(response));
    
    },
}

</script>