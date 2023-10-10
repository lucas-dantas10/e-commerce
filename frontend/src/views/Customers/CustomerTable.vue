<template>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">

        <div class="flex items-center justify-between border-b-2 pb-3">
            <div class="flex items-center gap-2">
                <label for="perPage">Por Página</label>

                <select v-model="perPage" @change="getCustomers(null)"
                    class="appearance-none relative block w-24 px-3 py-2 border border-gray-500 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>

                <span>Encontrado {{ !customers.total ? '0' : customers.total }} clientes</span>
            </div>

            <div>
                <input type="text" placeholder="Procurar Cliente" v-model="search" @change="getCustomers(null)"
                    class="py-2 px-4 border border-gray-300 placeholder-gray-500 text-sm rounded-md ">
            </div>
        </div>

        <table class="table-auto w-full">
            <thead>
                <tr>
                    <TableHeaderCell field="id" :sort-field="sortField" :sort-direction="sortDirection"
                        @click="sortCustomers('id')">
                        ID
                    </TableHeaderCell>
                    <TableHeaderCell field="name" :sort-field="sortField" :sort-direction="sortDirection"
                        @click="sortCustomers('name')">
                        Nome
                    </TableHeaderCell>
                    <TableHeaderCell field="email" :sort-field="sortField" :sort-direction="sortDirection"
                        @click="sortCustomers('email')">
                        Email
                    </TableHeaderCell>
                    <TableHeaderCell field="phone" :sort-field="sortField" :sort-direction="sortDirection"
                        @click="sortCustomers('phone')">
                        Telefone
                    </TableHeaderCell>
                    <TableHeaderCell field="status" :sort-field="sortField" :sort-direction="sortDirection"
                        @click="sortCustomers('status')">
                        Status
                    </TableHeaderCell>
                    <TableHeaderCell field="created_at" :sort-field="sortField" :sort-direction="sortDirection"
                        @click="sortCustomers('created_at')">
                        Data de Cadastro
                    </TableHeaderCell>
                    <TableHeaderCell field="actions">
                        Ações
                    </TableHeaderCell>
                </tr>
            </thead>

            <tbody v-if="customers.loading || !customers.data.length">
                <tr>
                    <td colspan="7">
                        <Spinner v-if="customers.loading" />
                        <p v-else class="text-center py-8 text-gray-700">
                            Não possui clientes
                        </p>
                    </td>
                </tr>
            </tbody>

            <tbody v-else>
                <tr v-for="(customer, index) in customers.data" :key="index">
                    <td class="border-b p-2 ">{{ customer.id }}</td>
                    <td class="border-b p-2 ">
                        {{ customer.first_name }} {{ customer.last_name }}
                    </td>
                    <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">
                        {{ customer.email }}
                    </td>
                    <td class="border-b p-2">
                        {{ customer.phone }}
                    </td>
                    <td class="border-b p-2">
                        <span class="text-white py-0.5 px-2 rounded" :class="{
                            'bg-emerald-500': customer.status === '1',
                            'bg-yellow-500': customer.status === '0'
                        }"
                        >
                            {{ customer.status == '1' ? 'ativo' : 'inativo' }}
                        </span>                        
                    </td>
                    <td class="border-b p-2">
                        {{ customer.created_at }}
                    </td>
                    <td class="border-b p-2 ">
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="inline-flex items-center w-full justify-center rounded-full h-10 bg-black bg-opacity-0 text-sm font-medium text-white hover:bg-opacity-5 focus:bg-opacity-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75">
                                    <EllipsisVerticalIcon class="h-5 w-5 text-indigo-500" aria-hidden="true" />
                                </MenuButton>
                            </div>

                            <transition enter-active-class="transition duration-100 ease-out"
                                enter-from-class="transform scale-95 opacity-0"
                                enter-to-class="transform scale-100 opacity-100"
                                leave-active-class="transition duration-75 ease-in"
                                leave-from-class="transform scale-100 opacity-100"
                                leave-to-class="transform scale-95 opacity-0">
                                <MenuItems
                                    class="absolute z-10 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="px-1 py-1">
                                        <MenuItem v-slot="{ active }">
                                        <router-link :to="{ name: 'app.customers.view', params: { id: customer.id } }" :class="[
                                            active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                        ]">
                                            <PencilIcon :active="active" class="mr-2 h-5 w-5 text-indigo-400"
                                                aria-hidden="true" />
                                            Editar
                                        </router-link>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <button :class="[
                                            active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                        ]" @click="deleteCustomer(customer)">
                                            <TrashIcon :active="active" class="mr-2 h-5 w-5 text-indigo-400"
                                                aria-hidden="true" />
                                            Deletar
                                        </button>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </td>
                </tr>
            </tbody>
        </table>

        <div v-if="!customers.loading" class="flex justify-between items-center mt-5">
                <div v-if="customers.data.length">
                    Mostrando de {{ customers.from }} de {{ customers.to }}
                </div>

                <nav 
                    v-if="customers.total > customers.limit"
                    class="relative z-0 inline-flex justify-center rounded-md shadow-sm space-x-px"    
                    aria-label="Pagination"
                >

                    <a
                        v-for="(link, index) in customers.links"
                        :key="index"
                        :disabled="!link.url"
                        href="#"
                        @click="getForPage($event, link)"
                        class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
                        :class="[
                            link.active
                                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                            i === 0 ? 'rounded-l-md' : '',
                            i === customers.links.length - 1 ? 'rounded-r-md' : '',
                            !link.url ? ' bg-gray-100 text-gray-700': ''
                            ]"
                        
                        v-html="link.label"

                    >
                    </a>

                </nav>
        </div>
    </div>
</template>

<script>
import TableHeaderCell from "../../components/core/Table/TableHeaderCell.vue";
import store from "../../store";
import Spinner from "../../components/core/Spinner.vue";
import {Menu, MenuItems, MenuButton, MenuItem} from '@headlessui/vue';
import { EllipsisVerticalIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/outline';

export default {

    data() {
        return {
            perPage: 10,
            sortField: 'created_at',
            sortDirection: 'desc',
            search: ''
        }
    },

    mounted() {
        this.getCustomers();
    },

    components: {
        TableHeaderCell,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        Spinner,
        PencilIcon,
        EllipsisVerticalIcon,
        TrashIcon
    },

    emits: ['edit-customer'],


    methods: {
        getCustomers(url=null) {
            store.dispatch('getCustomers', {
                url: url,
                per_page: this.perPage,
                sort_direction: this.sortDirection,
                sort_field: this.sortField,
                search: this.search
            });
        },

        editCustomer(customer) {
            //catch data with customers
            $this.emits('edit-customer', customer);
        },

        deleteCustomer(customer) {
            if (!confirm("Deseja excluir este cliente?")) {
                return;
            }

            store.dispatch("deleteCustomer", customer)
            .then(({data}) => this.getCustomers())
            .catch(({response}) => console.log(response.data));
        },

        sortCustomers(field) {
            if (field == this.field) {
                this.sortDirection == 'asc' ? this.sortDirection = 'desc' : this.sortDirection = 'asc';
            } else {
                this.field = field;
                this.sortDirection = 'asc';
            }

            this.getCustomers();
        }
    },

    computed: {
        customers() {
            // console.log(store.state.customers);
            return store.state.customers;
        }
    }
}
</script>