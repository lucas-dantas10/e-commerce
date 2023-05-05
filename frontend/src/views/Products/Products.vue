<template>
    <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Produtos</h1>

        <button
            class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            @click="showAddNewModal()"
            >
            Add novo produto
        </button>
    </div>

    <ProductsTable @click-edit="editProduct" />
    <ProductsModal :model-value="showProductModal" :product="productModel" @close="onModalClose" />
</template>

<script>
import ProductsTable from './ProductsTable.vue';
import store from '../../store';
import ProductsModal from './ProductsModal.vue';

export default {
    components: {
        ProductsTable,
        ProductsModal
    },

    data() {
        return {
            showProductModal: false,
            defaultProduct: {
                id: '',
                title: '',
                description: '',
                image: '',
                price: '',
                published: ''
            },
            productModel: {
                id: '',
                title: '',
                description: '',
                image: '',
                price: '',
                published: ''
            }
        }
    },

    methods: {

        editProduct(p) {
            store.dispatch('getProduct', p.id)
                .then(res => {
                    this.productModel = {
                        id: res.data.id,
                        title: res.data.title,
                        description: res.data.description,
                        image: res.data.image_url,
                        price: res.data.price,
                        published: ''
                    };
                    this.showAddNewModal();
                })
        },

        showAddNewModal() {
            this.showProductModal = true;
        },

        onModalClose() {
            this.productModel = { ...this.defaultProduct };
            this.showProductModal = false;
        }
    },

    computed: {
        products() {
            return store.state.products;
        }
    }
}
</script>