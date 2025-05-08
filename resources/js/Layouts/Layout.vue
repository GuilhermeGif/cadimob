<template>
    <v-app>
        <!-- Navbar -->
        <v-app-bar app color="primary" dark>
            <v-btn icon @click="toggleSidebar">
                <v-icon>mdi-menu</v-icon>
            </v-btn>
            <v-toolbar-title>CadImob</v-toolbar-title>
        </v-app-bar>

        <!-- Layout Principal -->
        <v-main>
            <v-container fluid class="d-flex">
                <!-- Sidebar -->
                <v-navigation-drawer app v-model="sidebar" color="grey-darken-3">
                <v-list dense>
                    <v-list-item v-for="(item, i) in menuItems" :key="i" class="p-0">
                    <template v-if="item.logout">
                        <Link
                        href="/logout"
                        method="post"
                        as="button"
                        class="flex items-center space-x-2 px-4 py-2 text-red-400 hover:text-red-600 hover:bg-red-100 dark:hover:bg-red-700 dark:hover:text-white rounded-md transition no-underline focus:outline-none w-full text-left"
                        >
                        <v-list-item-icon>
                            <v-icon size="20">{{ item.icon }}</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title class="font-semibold">{{ item.text }}</v-list-item-title>
                        </v-list-item-content>
                        </Link>
                    </template>
                    <template v-else>
                        <Link
                        :href="item.route"
                        class="flex items-center space-x-2 px-4 py-2 w-full text-white no-underline transition duration-200 ease-in-out hover:bg-gray-500 rounded-md"
                        >
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>{{ item.text }}</v-list-item-title>
                        </v-list-item-content>
                        </Link>
                    </template>
                    </v-list-item>
                </v-list>
                </v-navigation-drawer>


                <!-- Área de Conteúdo -->
                <v-container fluid class="mt-4">
                    <slot></slot> <!-- Aqui serão carregadas as páginas -->
                </v-container>
            </v-container>
        </v-main>
    </v-app>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3'; 
import { Inertia } from '@inertiajs/inertia';

const sidebar = ref(true);

const logout = () => {
    Inertia.post('/logout');
}

const toggleSidebar = () => {
    sidebar.value = !sidebar.value;
};

const menuItems = [
    { text: 'Dashboard', icon: 'mdi-view-dashboard', route: '/dashboard' },
    { text: 'Pessoas', icon: 'mdi-account-group', route: '/pessoas/index' },
    { text: 'Imóveis', icon: 'mdi-home-city', route: '/imoveis/index' },
    { text: 'Usuarios', icon: 'mdi-cog', route: '/users' },
    {text: 'Auditorias', route: '/auditorias' },
    {text: 'Sair', route: '/logout', logout: true },
];
</script>
