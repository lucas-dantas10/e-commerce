<template>
    <TransitionRoot as="template" :show="show">
        <Dialog as="div" class="relative z-10" @close="show = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-black bg-opacity-70 transition-opacity" />
            </TransitionChild>

            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-[700px] sm:w-full">
                            <Spinner v-if="loading"
                                class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center" />
                            <header class="py-3 px-4 flex justify-between items-center">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                                    {{ product.id ? `Update product: "${props.product.title}"` : 'Create new Product' }}
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
                            <form @submit.prevent="onSubmit">
                                <div class="bg-white px-4 pt-5 pb-4">
                                    <CustomInput class="mb-2" v-model="product.title" label="Product Title" />
                                    <CustomInput type="file" class="mb-2" label="Product Image"
                                        @change="file => product.image = file" />
                                    <CustomInput type="textarea" class="mb-2" v-model="product.description"
                                        label="Description" />
                                    <CustomInput type="number" class="mb-2" v-model="product.price" label="Price"
                                        prepend="$" />
                                    <CustomInput type="checkbox" class="mb-2" v-model="product.published"
                                        label="Published" />
                                </div>
                                <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm
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
export default {
    components: {
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot
    },
    data() {
        return {
            loading: false,
            product: this.product
        }
    },

    emits: ['close', 'update:modelValue'],

    props: {
        modelValue: Boolean,
        product: {
            type: Object,
            required: true
        }
    },

    methods: {
        closeModal() {
            this.show = false;
            this.$emit('close');
        }
    },

    computed: {
        show() {
            return {
                get: () => this.modelValue,
                set: (value) => this.$emit('update:modelValue', value)
            }
        },

        onSubmit() {
            this.loading = true;
            if (this.product.id) {
                store.dispatch('updateProduct', this.product)
                    .then(response => {
                        loading.value = false;
                        if (response.status === 200) {
                            // TODO show notification
                            store.dispatch('getProducts')
                            closeModal()
                        }
                    })
            } else {
                store.dispatch('createProduct', this.product)
                    .then(response => {
                        loading.value = false;
                        if (response.status === 201) {
                            // TODO show notification
                            store.dispatch('getProducts')
                            closeModal()
                        }
                    })
                    .catch(err => {
                        loading.value = false;
                        debugger;
                    })
            }
        }
    },

    updated() {
        this.product = {
            id: this.product.id,
            title: this.product.title,
            image: this.product.image,
            description: this.product.description,
            price: this.product.price,
            published: this.product.published
        }
    }
}
</script>