<template>
    <TransitionRoot as="template" :show="show">
        <Dialog as="div" class="relative z-10" @close="show = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-black bg-opacity-70 transition-opacity" />
            </TransitionChild>

            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                    <TransitionChild enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <DialogPanel class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-[700px] sm:w-full">
                            <Spinner v-if="loading" class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center" />
                            <header class="py-3 px-4 flex justify-between items-center">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                                    {{ products.id ? `Atualizando Produto: "${products.title}"` : 'Criando novo Produto' }}
                                </DialogTitle>
                                <button @click="closeModal()"
                                    class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </header>
                            <form @submit.prevent="onSubmit" enctype="multipart/form-data">
                                <div class="bg-white px-4 pt-5 pb-4">
                                    <CustomInput 
                                        class="mb-2" 
                                        v-model:modelInput="products.title" 
                                        label="Título do Produto" 
                                    />

                                    <CustomInput 
                                        type="file" 
                                        class="mb-2" 
                                        label="Imagem do Produto"
                                        v-model:modelInput="products.image"
                                        @change="file => products.image = file" 
                                    />
                                    
                                    <CustomInput 
                                        type="textarea" 
                                        class="mb-2" 
                                        :required="false"
                                        v-model:modelInput="products.description"
                                        label="Descrição" 
                                    />

                                    <CustomInput 
                                        type="number" 
                                        class="mb-2" 
                                        v-model:modelInput="products.price" 
                                        label="Preço"
                                        prepend="$" 
                                    />

                                    <!-- <CustomInput 
                                        type="checkbox" 
                                        class="mb-2" 
                                        :v-model:modelInput="products.published"
                                        label="Publicar" 
                                    /> -->
                                </div>
                                <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm
                                            text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
                                        Enviar
                                    </button>
                                    <button type="button"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                        @click="closeModal" ref="cancelButtonRef">
                                        Cancelar
                                    </button>
                                </footer>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import CustomInput from "../../components/core/CustomInput.vue";
import Spinner from "../../components/core/Spinner.vue";
import { computed } from 'vue';
import store from '../../store';
export default {
    name: 'produtos-modal',
    components: {
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        Spinner,
        CustomInput
    },

    data() {
        return {
            loading: false,
            products: this.product
        }
    },

    setup(props, { emit }) {
        const show = computed({
            get: () => props.modelValue,
            set: (value) => emit('update:modelValue', value)
        })

        return {
            show
        }
    },

    updated() {
        this.products = {
            id: this.product.id,
            title: this.product.title,
            image: this.product.image_url,
            description: this.product.description,
            price: this.product.price,
            published: this.product.published
        }
    },

    props: {
        modelValue: Boolean,
        product: {
            type: Object,
            required: true
        }
    },
    
    emits: ['update:modelValue', 'close'],

    methods: {
        closeModal() {
            this.show = false;
            this.$emit('close');
        },

        onSubmit() {
            this.loading = true;
            // console.log(this.products);
            if (this.product.id) {
                store.dispatch('updateProduct', this.products)
                    .then(response => {
                        this.loading = false;
                        if (response.status === 200) {
                            // TODO show notification
                            store.dispatch('getProducts')
                            this.closeModal()
                        }
                    })
            } else {
                store.dispatch('createProduct', this.products)
                    .then(response => {
                        this.loading = false;
                        if (response.status === 201) {
                            // TODO show notification
                            store.commit('showToast', 'Produto foi cadastrado com sucesso');
                            store.dispatch('getProducts');
                            this.closeModal();
                        }
                    })
                    .catch(err => {
                        this.loading = false;
                        console.log(err);
                        debugger;
                    })
            }
        }
    },
}
</script>