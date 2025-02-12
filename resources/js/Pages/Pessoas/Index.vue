<script setup>
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
    <Head title="Lista de Pessoas" />
    <div class="p-6 bg-white rounded-lg shadow-md max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Lista de Pessoas</h1>
        
        <div class="flex justify-between items-center mb-4">
            <Link href="/pessoas/create" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                + Cadastrar Pessoa
            </Link>
        </div>

        <table class="w-full border-collapse bg-white shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border p-2">Nome</th>
                    <th class="border p-2">CPF</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2 text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="pessoa in pessoas" :key="pessoa.id" class="hover:bg-gray-100">
                    <td class="border p-2">{{ pessoa.nome }}</td>
                    <td class="border p-2">{{ pessoa.cpf }}</td>
                    <td class="border p-2">{{ pessoa.email }}</td>
                    <td class="border p-2 flex justify-center gap-2">
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

        <div v-if="pessoas.length === 0" class="text-center text-gray-500 mt-4">
            Nenhuma pessoa cadastrada.
        </div>
    </div>
</template>
