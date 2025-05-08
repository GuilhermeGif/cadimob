<template>
    <Layout>
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Lista de Usuários</h1>
                <Link v-bind:href="route('register')" class="bg-green-500 text-white px-4 py-2 no-underline transition duration-200 ease-in-out hover:bg-green-700 rounded-md mb-4 inline-block">
                    + Registrar Usuário
                </Link>
            </div>
        
            <table class="w-full border-collapse mt-4">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">ID</th>
                        <th class="border p-2">Nome</th>
                        <th class="border p-2">E-mail</th>
                        <th class="border p-2">Perfil</th> 
                        <th class="border p-2">Ativo</th>
                        <th class="border p-2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users.data" :key="user.id" class="border-b">
                        <td class="border p-2">{{ user.id }}</td>
                        <td class="border p-2">{{ user.name }}</td>
                        <td class="border p-2">{{ user.email }}</td>
                        <td class="border p-2">{{ perfilUser (user.profile) }}</td>
                        <td class="border p-2">{{ user.active === 'S' ? 'Ativo' : 'Desativado' }}</td>
                        <td class="border p-2 flex gap-2 justify-center">
                            <Link :href="`/users/${user.id}/edit`" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                Editar
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Controles de Paginação -->
            <div class="mt-4 flex justify-center">
                <nav class="inline-flex rounded-md shadow">
                    <Link 
                        v-for="(link, index) in users.links" 
                        :key="index" 
                        :href="link.url || '#'" 
                        :class="{
                            'bg-blue-500 text-white': link.active,
                            'bg-white text-gray-700': !link.active
                        }" 
                        class="px-4 py-2 border rounded-md mx-1"
                        v-html="link.label"
                    />
                </nav>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    users: Object,
});

const perfilUser  = (tipoPerfil) => {
    let perfil = '';
    switch(tipoPerfil) {
        case 'T':
            perfil = 'Admin TI';
            break;
        case 'S':
            perfil = 'Admin Sist.';
            break;
        case 'A':
            perfil = 'Atendente';
            break;
        default:
            perfil = 'Desconhecido';
    }
    return perfil;
}

const deleteUser  = (id) => {
    if (confirm('Tem certeza que deseja excluir?')) {
        router.delete(route('users.destroy', id), {
            preserveScroll: true,
            onSuccess: () => alert('Usuário excluído com sucesso!'),
            onError: () => alert('Erro ao excluir o usuário.'),
        });
    }
};
</script>

<style scoped>
.table {
    width: 100%;
    border-collapse: collapse;
}

.table th, .table td {
    border: 1px solid #ddd;
    padding: 8px;
}

.table th {
    background-color: #f2f2f2;
}
</style>