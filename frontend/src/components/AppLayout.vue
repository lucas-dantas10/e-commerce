<template>
    <div class="min-h-full bg-gray-200 flex">

        <Sidebar :class="{'-ml-[200px]' : !sidebarOpened}" />

        <div class="flex-1">
            <Navbar @toggle-sidebar="toggleSidebar" />

            <main class="p-6">
                <router-view></router-view>
            </main>
        </div>

    </div>
</template>

<script>
import Sidebar from '../components/Sidebar.vue';
import Navbar from '../components/Navbar.vue';

export default {
    components: {
        Sidebar,
        Navbar
    },

    data() {
        return {
            sidebarOpened: true
        }
    },

    methods: {
        toggleSidebar() {
            this.sidebarOpened = !this.sidebarOpened;
        }
    }
}
</script>
