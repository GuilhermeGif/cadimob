<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

// Definição das props
const props = defineProps({ pessoas: Object });

// Variáveis reativas para os filtros
const nome = ref('');
const cpf = ref('');
const dataNascimento = ref('');
const sexo = ref('');

// Função para formatar o CPF
const formatCPF = (cpf) => {
    return cpf.replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
};


// Função para formatar a data
const formatDate = (date) => {
    if (!date) return ''; 
    const year = date.slice(0, 4);
    const month = date.slice(5, 7);
    const day = date.slice(8, 10);
    return `${day}/${month}/${year}`;
}

// Computed para filtrar as pessoas
const filteredPessoas = computed(() => {
    return props.pessoas.data.filter(pessoa => {

        return (
            (nome.value === '' || pessoa.nome.toLowerCase().includes(nome.value.toLowerCase())) &&
            (cpf.value === '' || pessoa.cpf.includes(cpf.value)) &&
            (dataNascimento.value === '' || pessoa.data_nascimento.includes(dataNascimento.value)) && // 
            (sexo.value === '' || pessoa.sexo.toLowerCase() === sexo.value.toLowerCase())
        );
    });
});

// Função para deletar pessoa com feedback visual
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
                <Link href="/pessoas/create" class="bg-green-500 text-white px-4 py-2 no-underline transition duration-200 ease-in-out hover:bg-green-700 rounded-md mb-4 inline-block">
                    + Cadastrar Pessoa
                </Link>
            </div>

            <!-- Formulário de Filtro -->
            <div class="mb-4">
                <input v-model="nome" type="text" placeholder="Nome" class="border p-2 mr-2" />
                <input v-model="cpf" type="text" placeholder="CPF" class="border p-2 mr-2" />
                <input v-model="dataNascimento" type="date" placeholder="Data Nascimento" class="border p-2 mr-2" />
                <select v-model="sexo" class="border p-2 mr-2">
                    <option value="">Sexo</option>
                    <option value="masculino">Masculino</option>
                    <option value="feminino">Feminino</option>
                </select>
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
                    <tr v-for="pessoa in filteredPessoas" :key="pessoa.id" class="border-b">
                        <td class="border p-2">{{ pessoa.id }}</td>
                        <td class="border p-2">{{ pessoa.nome }}</td>
                        <td class="border p-2">{{ formatCPF(pessoa.cpf) }}</td>
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

            <!-- Controles de Paginação -->
            <div class="mt-4 flex justify-center">
                <nav class="inline-flex rounded-md shadow">
                    <Link 
                        v-for="(link, index) in pessoas.links" 
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