<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    nome: '',
    data_nascimento: '',
    cpf: '',
    sexo: '',
    telefone: '',
    email: '',
});

const submit = () => {
    form.post('/pessoas');
};
</script>

<template>
    <Head title="Cadastrar Pessoa" />
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Cadastrar Pessoa</h1>
        <form @submit.prevent="submit">
            <input v-model="form.nome" type="text" placeholder="Nome" class="border p-2 w-full mb-2" required />
            <input v-model="form.data_nascimento" type="date" class="border p-2 w-full mb-2" required />
            <input v-model="form.cpf" type="text" placeholder="CPF" class="border p-2 w-full mb-2" required />
            <select v-model="form.sexo" class="border p-2 w-full mb-2">
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
            </select>
            <input v-model="form.telefone" type="text" placeholder="Telefone" class="border p-2 w-full mb-2" />
            <input v-model="form.email" type="email" placeholder="E-mail" class="border p-2 w-full mb-2" required />
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Salvar</button>
        </form>
    </div>
</template>
