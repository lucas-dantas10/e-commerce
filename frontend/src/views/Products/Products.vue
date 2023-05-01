<template>
    <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Produtos</h1>

        <button 
            class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"               
        >
            Add novo produto
        </button>
    </div>

    <ProductsTable @click-edit="editProduct"/>
    <ProductModal v-model="showProductModal" :product="productModel" @close="onModalClose"/>
</template>

<script>
import ProductsTable from './ProductsTable.vue';
import store from '../../store';
// import ProductModal from './ProductModal.vue';

export default {
    components: {
        ProductsTable,
        // ProductModal
    },

    data() {
        return {
            showProductModal: false,
            defaultProduct: {
                id: '',
                title: '',
                description: '',
                image: '',
                price: ''
            },
            productModel: ''
        }
    },

    mounted() {
        this.productModel = {...this.defaultProduct};
    },

    methods: {

        editProduct(p) {
            store.dispatch('getProducts', p.id)
            .then(data => {
                this.productModel = data;
                this.showAddNewModal();
            })
        },

        showAddNewModal() {
            this.showProductModal = true;
        },

        onModalClose() {
            this.productModel = {...this.defaultProduct};
        }
    },

    computed: {
        products() {
            return store.state.products;
        }
    }
}
</script>