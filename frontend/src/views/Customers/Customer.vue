<template>
    <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Clientes</h1>
    </div>

    <CustomerTable @edit-customer="edit()"/>
</template>

<script>

import CustomerTable from './CustomerTable.vue';

export default {
    components: {
        CustomerTable
    },
    methods: {
        edit(customer) {
            // edit with store.dispatch
        }
    }
}
</script>