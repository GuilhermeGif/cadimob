<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({ pessoas: Array });

const formatDate = (date) => new Date(date).toLocaleDateString('pt-BR');

const deletePessoa = (id) => {
    if (confirm('Tem certeza que deseja excluir?')) {
        router.delete(route('pessoas.destroy', id), {
            preserveScroll: true,
            onSuccess: () => alert('Registro excluído com sucesso!'),
            onError: () => alert('Erro ao excluir o registro.'),
        });
    }
};
</script>

<template>
    <Layout>
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Lista de Pessoas</h1>
            <Link href="/pessoas/create" class="bg-green-500 text-white px-4 py-2 rounded-md mb-4 inline-block">
                + Cadastrar Pessoa
            </Link>
            </div>
        
        <table class="w-full border-collapse mt-4">
            <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">ID</th>
                <th class="border p-2">Nome</th>
                <th class="border p-2">CPF</th>
                <th class="border p-2">Data Nasc.</th>
                <th class="border p-2">Sexo</th>
                <th class="border p-2">Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="pessoa in pessoas" :key="pessoa.id" class="border-b">
                <td class="border p-2">{{ pessoa.id }}</td>
                <td class="border p-2">{{ pessoa.nome }}</td>
                <td class="border p-2">{{ pessoa.cpf }}</td>
                <td class="border p-2">{{ formatDate(pessoa.data_nascimento) }}</td>
                <td class="border p-2">{{ pessoa.sexo }}</td>
                <td class="border p-2 flex gap-2 justify-center">
                <Link :href="`/pessoas/${pessoa.id}/edit`" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                    Editar
                </Link>
                <button @click="deletePessoa(pessoa.id)" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                    Excluir
                </button>
                </td>
            </tr>
            </tbody>
        </table>
        </div>
    </Layout>
</template>
