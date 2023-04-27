<template>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
        <div class="flex justify-between border-b-2 pb-3">
            <div class="flex items-center">
                <span class="whitespace-nowrap mr-3">Por Página</span>

                <select 
                    @change="getProducts(null)" v-model="perPage"
                    class="appearance-none relative block w-24 px-3 py-2 border border-gray-500 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>

                <span class="ml-3">Found {{products.total}} products</span>
            </div>

            <div>
                <input type="text" @change="getProducts(null)" v-model="search"
                    class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                    placeholder="Buscar produto">
            </div>
        </div>

        <table class="table-auto w-full">
            <thead>
                <tr>
                    <TableHeaderCell 
                        field="id" :sort-field="sortField" :sort-direction="sortDirection" @click="sortProducts('id')">
                        ID
                    </TableHeaderCell>

                    <TableHeaderCell field="image" :sort-field="sortField" :sort-direction="sortDirection" @click="sortProducts('image')">
                        Imagem
                    </TableHeaderCell>

                    <TableHeaderCell field="title" :sort-field="sortField" :sort-direction="sortDirection" @click="sortProducts('title')">
                        Titulo
                    </TableHeaderCell>

                    <TableHeaderCell field="price" :sort-field="sortField" :sort-direction="sortDirection" @click="sortProducts('price')">
                        Preço
                    </TableHeaderCell>

                    <TableHeaderCell field="updated_at" :sort-field="sortField" :sort-direction="sortDirection" @click="sortProducts('updated_at')">
                        Última atualização
                    </TableHeaderCell>

                    <TableHeaderCell field="actions">
                        Ações
                    </TableHeaderCell>
                </tr>
            </thead>
        </table>
    </div>
</template>

<script>
import store from '../../store';
import TableHeaderCell from "../../components/core/Table/TableHeaderCell.vue";

export default {
    components: {
        TableHeaderCell
    },

    data() {
        return {
            perPage: '',
            search: '',
            sortField: 'updated_at',
            sortDirection: 'desc'
        }
    },

    mounted() {
        this.getProducts();
    },  

    methods: {
        getProducts(url = null) {
            store.dispatch('getProducts', {
                url,
                search: this.search,
                per_page: this.perPage,
                sort_field: this.sortField,
                sort_direction: this.sortDirection
            });
        },

        sortProducts(field) {
            if (field === this.sortField) {
                this.sortDirection === 'desc' ? this.sortDirection = 'asc' : this.sortDirection = 'desc';
            } else {
                this.sortField = field;
                this.sortDirection = 'asc';
            }

            this.getProducts();
        }
    },

    computed: {
        products() {
            return store.state.products;
        }
    }
}
</script>