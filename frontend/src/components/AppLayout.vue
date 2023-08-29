<template>
    <div v-if="currentUser.id" class="min-h-full bg-gray-200 flex">

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
import store from '../store';

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

    mounted() {
        store.dispatch('getCurrentUser');
        store.dispatch('getCountries');
        this.updateSidebarState();
        window.addEventListener('resize', this.updateSidebarState);
    },

    unmounted() {
        window.removeEventListener('resize', this.updateSidebarState);
    },

    methods: {
        toggleSidebar() {
            this.sidebarOpened = !this.sidebarOpened;
        },

        updateSidebarState() {
            this.sidebarOpened = window.outerWidth > 768;
        }
    },

    computed: {
        currentUser() {
            return store.state.user.data;
        }
    }
}
</script>
