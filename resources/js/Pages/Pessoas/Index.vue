<script setup>
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({ pessoas: Array });

const formatDate = (date) => new Date(date).toLocaleDateString('pt-BR');

const deletePessoa = (id) => {
    if(confirm('Tem certeza que deseja excluir?')) {
        router.delete(route('pessoas.destroy', id)), {
            preserveScroll: true, //mantem a rolagem na pagina (evita dar pagina expirada quando deleta)
            onSuccess: () => {
                alert('Registro excluido com sucesso!')
            }
        }
    }
};

</script>

<template>
    <Head title="Lista de Pessoas" />
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Lista de Pessoas</h1>
        <Link href="/pessoas/create" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-4 inline-block">
            Cadastrar Pessoa
        </Link>
        <table class="w-full border-collapse mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Nome</th>
                    <th class="border p-2">CPF</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="pessoa in pessoas" :key="pessoa.id" class="border-b">
                    <td class="border p-2">{{ pessoa.nome }}</td>
                    <td class="border p-2">{{ pessoa.cpf }}</td>
                    <td class="border p-2">{{ pessoa.email }}</td>
                    <td class="border p-2">
                        <Link :href="`/pessoas/${pessoa.id}/edit`" class="bg-blue-500 text-white px-4 py-3 rounded-md">Editar</Link>
                        <form :action="`/pessoas/${pessoa.id}`" method="POST" class="inline">
                            <input type="hidden" name="_method" value="DELETE" />
                            <button @click="deletePessoa(pessoa.id)" class="bg-red-500 text-white px-2 py-2 rounded-md">Excluir</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>