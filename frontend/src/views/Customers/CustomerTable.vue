<template>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">

        <div class="flex items-center justify-between border-b-2 pb-3">
            <div class="flex items-center gap-2">
                <label for="perPage">Por Página</label>

                <select v-model="perPage"
                    class="appearance-none relative block w-24 px-3 py-2 border border-gray-500 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>

                <!-- <span>Encontrado {{ !customers.total ? '0' : customers.total }} clientes</span> -->
            </div>

            <div>
                <input type="text" placeholder="Procurar Clientes"
                    class="py-2 px-4 border border-gray-300 placeholder-gray-500 text-sm rounded-md ">
            </div>
        </div>

        <table class="table-auto w-full">
            <thead>
                <tr>
                    <TableHeaderCell field="id" :sort-field="sortField" :sort-direction="sortDirection" 
                        @click="sortCustomers('id')"
                    >
                        ID
                    </TableHeaderCell>
                    <TableHeaderCell field="name" :sort-field="sortField" :sort-direction="sortDirection" 
                        @click="sortCustomers('name')"
                    >
                        Nome
                    </TableHeaderCell>
                    <TableHeaderCell field="email" :sort-field="sortField" :sort-direction="sortDirection" 
                        @click="sortCustomers('email')"
                    >
                        Email
                    </TableHeaderCell>
                    <TableHeaderCell field="phone" :sort-field="sortField" :sort-direction="sortDirection"
                         @click="sortCustomers('phone')"
                        >
                        Telefone
                    </TableHeaderCell>
                    <TableHeaderCell field="status" :sort-field="sortField" :sort-direction="sortDirection" 
                        @click="sortCustomers('status')"
                    >
                        Status
                    </TableHeaderCell>
                    <TableHeaderCell field="created_at" :sort-field="sortField" :sort-direction="sortDirection" 
                        @click="sortCustomers('created_at')"
                    >
                        Data de Cadastro
                    </TableHeaderCell>
                    <TableHeaderCell field="actions">
                        Ações
                    </TableHeaderCell>
                </tr>
            </thead>

            <tbody>

            </tbody>
        </table>

    </div>
</template>

<script>
import TableHeaderCell from "../../components/core/Table/TableHeaderCell.vue";

export default {

    data() {
        return {
            perPage: 10,
            sortField: 'created_at',
            sortDirection: 'desc',
            search: ''
        }
    },

    components: {
        TableHeaderCell
    },

    emits: ['edit-customer'],


    methods: {
        edit(customer) {
            //catch data with customers
            $this.emits('edit-customer', customer);
        },

        sortCustomers(field) {
            if (field == this.field) {
                this.sortDirection == 'asc' ? this.sortDirection = 'desc' :  this.sortDirection = 'asc';
            } else {
                this.field = field;
                this.sortDirection = 'asc';
            }

            // this.getProducts();
        }
    }
}
</script>