<template>
    <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Usuários</h1>

        <button
            class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            @click="showAddNewModal()"
        >
            Add novo usuário
        </button>
    </div>

    <UsersTable @click-edit="editUser"/>

    <UsersModal :model-value="showModelProduct" :users="usersModel" @close="onModalClose" />
</template>

<script>

import UsersTable from './UsersTable.vue';
import UsersModal from './UsersModal.vue';
import store from '../../store';

export default {
    components: {
        UsersTable,
        UsersModal
    },

    data() {
        return {
            showModelProduct: false,
            defaultUser: {
                id: '',
                name: '',
                email: '',
                password: ''
            },

            usersModel: {
                id: '',
                name: '',
                email: '',
                password: ''
            }
        }
    },

    methods: {
        showAddNewModal() {
            this.showModelProduct = true;
        },

        onModalClose() {
            this.usersModel = {...this.defaultUser};
            this.showModelProduct = false;
        },

        editUser(user) {
             store.dispatch("getUser", user.id)
                .then(({data}) => {
                    this.usersModel = data;
                })
                .catch(({data}) => {
                    console.log(data);
                })
            this.showAddNewModal();
        }
    }
}

</script>