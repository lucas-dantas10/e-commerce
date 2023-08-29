<template>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
        <div class="flex justify-between border-b-2 pb-3">
            <div class="flex items-center">
                <span class="whitespace-nowrap mr-3">Por Página</span>

                <select @change="getUsers(null)" v-model.number="perPage"
                    class="appearance-none relative block w-24 px-3 py-2 border border-gray-500 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>

                <span class="ml-3">Encontrado {{ !users.total ? '0' : users.total }} usuários</span>
            </div>

            <div>
                <input type="text" @change="getUsers(null)" v-model="search"
                    class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                    placeholder="Buscar Usuário">
            </div>
        </div>

        <table class="table-auto w-full">
            <thead>
                <TableHeaderCell field="id" :sort-field="sortField" :sort-direction="sortDirection"
                        @sort-table="sortUsers('id')">
                        ID
                    </TableHeaderCell>

                    <TableHeaderCell field="name" :sort-field="sortField" :sort-direction="sortDirection"
                        @sort-table="sortUsers('name')">
                        Nome
                    </TableHeaderCell>

                    <TableHeaderCell field="email" :sort-field="sortField" :sort-direction="sortDirection"
                        @sort-table="sortUsers('email')">
                        Email
                    </TableHeaderCell>

                    <TableHeaderCell field="updated_at" :sort-field="sortField" :sort-direction="sortDirection"
                        @sort-table="sortUsers('updated_at')">
                        Última atualização
                    </TableHeaderCell>

                    <TableHeaderCell field="actions">
                        Ações
                    </TableHeaderCell>
            </thead>

            <tbody v-if="users.loading || !users.data.length">
                <tr>
                    <td colspan="6">
                        <Spinner v-if="users.loading" />
                        <p v-else class="text-center py-8 text-gray-700">
                            Não possui usuários cadastrados
                        </p>
                    </td>
                </tr>
            </tbody>

            <tbody v-else>
                <tr v-for="(user, index) in users.data" :key="index">
                    <td class="border-b p-2">{{ user.id }}</td>
                    <td class="border-b p-2">{{ user.name }}</td>
                    <td class="border-b p-2">{{ user.email }}</td>
                    <td class="border-b p-2">{{ user.updated_at }}</td>
                    <td class="border-b p-2 ">
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="inline-flex items-center  justify-center rounded-full w-10 h-10 bg-black bg-opacity-0 text-sm font-medium text-white hover:bg-opacity-5 focus:bg-opacity-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75">
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
                                        <button :class="[
                                                active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                            ]" @click="editUser(user)">
                                            <PencilIcon :active="active" class="mr-2 h-5 w-5 text-indigo-400"
                                                aria-hidden="true" />
                                            Editar
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <button :class="[
                                                active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                            ]" @click="deleteUser(user)">
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
        <div v-if="!users.loading" class="flex justify-between items-center mt-5">
            <div v-if="users.data.length">
                Mostrando de {{ users.from }} a {{ users.to }}
            </div>
            <nav v-if="users.total > users.limit" class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <a v-for="(link, i) of users.links" :key="i" :disabled="!link.url" href="#"
                    @click.prevent="getForPage($event, link)" aria-current="page"
                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap" :class="[
                            link.active
                                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                            i === 0 ? 'rounded-l-md' : '',
                            i === users.links.length - 1 ? 'rounded-r-md' : '',
                            !link.url ? ' bg-gray-100 text-gray-700' : ''
                        ]" v-html="link.label">
                </a>
            </nav>
        </div>
    </div>
</template>

<script>
import store from '../../store';
import TableHeaderCell from '../../components/core/Table/TableHeaderCell.vue';
import Spinner from "../../components/core/Spinner.vue";
import {Menu, MenuItems, MenuButton, MenuItem} from '@headlessui/vue';
import { EllipsisVerticalIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/outline';

export default {

    components: {
        TableHeaderCell,
        Spinner,
        Menu,
        MenuItem,
        MenuItems,
        MenuButton,
        EllipsisVerticalIcon,
        PencilIcon,
        TrashIcon
    },

    data() {
        return {
            perPage: 10,
            search: '',
            sortField: 'updated_at',
            sortDirection: 'desc',
        }
    },

    emits: ['click-edit'],

    mounted() {
        this.getUsers();
    },

    methods: {
        getUsers(url = null) {
            store.dispatch('getUsers', {
                url,
                search: this.search,
                per_page: this.perPage,
                sort_field: this.sortField,
                sort_direction: this.sortDirection
            });
        },
        
        editUser(user) {
            this.$emit('click-edit', user);
        },

        deleteUser(user) {
            if (!confirm("Deseja deletar este usuário?")) {
                return;
            }

            store.dispatch("deleteUser", user)
                .then(res =>  {
                    this.getUsers();
                })
                .catch(err => {
                    debugger;
                    console.log(err);
                });
        },

        sortUsers(field) {
            if (field === this.sortField) {
                this.sortDirection === 'desc' ? this.sortDirection = 'asc' : this.sortDirection = 'desc';
            } else {
                this.sortField = field;
                this.sortDirection = 'asc';
            }

            this.getUsers();
        },

        getForPage(event, link) {
            if (!link.url || link.active) {
                return;
            }

            this.getUsers(link.url);
        }
    },

    computed: {
        users() {
            return store.state.users;
        }
    }
}
</script>
