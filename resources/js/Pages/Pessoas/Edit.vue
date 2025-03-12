<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    pessoa: Object,
});

const form = useForm({
    nome: props.pessoa.nome,
    data_nascimento: props.pessoa.data_nascimento,
    cpf: props.pessoa.cpf,
    sexo: props.pessoa.sexo,
    telefone: props.pessoa.telefone,
    email: props.pessoa.email,
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        telefone: data.telefone.replace(/\D/g, ''),
    })).put(`/pessoas/${props.pessoa.id}`, {
        onError: (errors) => {
            console.log(errors);
        },
    });
};
</script>

<template>
    <Head title="Editar Pessoa" />
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Editar Pessoa</h1>
        <form @submit.prevent="submit">
            <!-- Nome -->
            <div class="mb-4">
                <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
                <input v-model="form.nome" type="text" placeholder="Nome" class="border p-2 w-full" required />
                <span v-if="form.errors.nome" class="text-red-500 text-sm">{{ form.errors.nome }}</span>
            </div>

            <!-- Data de Nascimento -->
            <div class="mb-4">
                <label for="data_nascimento" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
                <input v-model="form.data_nascimento" type="date" class="border p-2 w-full" required />
                <span v-if="form.errors.data_nascimento" class="text-red-500 text-sm">{{ form.errors.data_nascimento }}</span>
            </div>

            <!-- CPF -->
            <div class="mb-4">
                <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>
                <input v-model="form.cpf" type="text" placeholder="CPF" class="border p-2 w-full" required readonly />
                <span v-if="form.errors.cpf" class="text-red-500 text-sm">{{ form.errors.cpf }}</span>
            </div>

            <!-- Sexo -->
            <div class="mb-4">
                <label for="sexo" class="block text-sm font-medium text-gray-700">Sexo</label>
                <select v-model="form.sexo" class="border p-2 w-full">
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                </select>
                <span v-if="form.errors.sexo" class="text-red-500 text-sm">{{ form.errors.sexo }}</span>
            </div>

            <!-- Telefone -->
            <div class="mb-4">
                <label for="telefone" class="block text-sm font-medium text-gray-700">Telefone</label>
                <input v-model="form.telefone" type="text" placeholder="Telefone" class="border p-2 w-full" />
                <span v-if="form.errors.telefone" class="text-red-500 text-sm">{{ form.errors.telefone }}</span>
            </div>

            <!-- E-mail -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                <input v-model="form.email" type="email" placeholder="E-mail" class="border p-2 w-full" required />
                <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
            </div>

            <!-- Botão de envio -->
            <button type="submit" :disabled="form.processing" class="bg-green-500 text-white px-4 py-2 rounded-md">
                {{ form.processing ? 'Atualizando...' : 'Atualizar' }}
            </button>
        </form>
    </div>
</template>