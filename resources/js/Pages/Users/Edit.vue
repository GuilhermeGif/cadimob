<template>
    <Layout>
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-4">Editar Usuário</h1>
            <form @submit.prevent="updateUser ">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                    <input
                        type="text"
                        id="name"
                        v-model="form.name"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500"
                        required
                    />
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input
                        type="email"
                        id="email"
                        v-model="form.email"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500"
                        required
                        readonly
                    />
                </div>

                <div class="mb-4">
                    <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>
                    <input
                        type="text"
                        id="cpf"
                        v-model="form.cpf"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500"
                        required
                        readonly
                    />
                </div>

                <div class="mb-4">
                    <label for="profile" class="block text-sm font-medium text-gray-700">Perfil</label>
                    <select
                        id="profile"
                        v-model="form.profile"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500"
                        required
                    >
                        <option value="T">Administrador da TI</option>
                        <option value="S">Administrador do sistema</option>
                        <option value="A">Atendente</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="active" class="block text-sm font-medium text-gray-700">Ativo</label>
                    <select
                        id="active"
                        v-model="form.active"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500"
                        required
                    >
                        <option value="S">Ativo</option>
                        <option value="N">Desativado</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition"
                    >
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </Layout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Layout from '@/Layouts/Layout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
});

const form = useForm({
    id: props.user.id,
    name: props.user.name,
    email: props.user.email,
    cpf: props.user.cpf,
    profile: props.user.profile,
    active: props.user.active,
});

const updateUser  = () => {
    form.put(route('users.update', { id: props.user.id }), {
        onSuccess: () => {
            alert('Usuário atualizado com sucesso!');
        },
        onError: () => {
            alert('Erro ao atualizar o usuário.');
        },
    });
};
</script>
