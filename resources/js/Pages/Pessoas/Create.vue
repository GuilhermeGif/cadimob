<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { mask } from "vue-the-mask";

const vMask = mask;

const form = useForm({
    nome: '',
    data_nascimento: '',
    cpf: '',
    sexo: '',
    telefone: '',
    email: '',
});

// Função para validar o CPF
const validateCPF = (cpf) => {
    cpf = cpf.replace(/\D/g, '');
    if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;
    for (let t = 9; t < 11; t++) {
        let d = 0;
        for (let c = 0; c < t; c++) d += cpf[c] * ((t + 1) - c);
        d = ((10 * d) % 11) % 10;
        if (cpf[t] != d) return false;
    }
    return true;
};

// Função para formatar o telefone
const formatPhone = (phone) => {
    return phone
        .replace(/\D/g, '')
        .replace(/^(\d{2})(\d)/g, '($1) $2')
        .replace(/(\d{5})(\d)/, '$1-$2');
};

// Função para validar a idade
const validateAge = (date) => {
    const today = new Date();
    const birthDate = new Date(date);
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) age--;
    return age >= 18;
};

const submit = () => {
    // Remove a formatação do CPF e Telefone antes de enviar
    form.transform((data) => ({
        ...data,
        cpf: data.cpf.replace(/\D/g, ''), // Remove formatação do CPF
        telefone: data.telefone.replace(/\D/g, ''), // Remove formatação do Telefone
    })).post(route('pessoas.store'), {
        onError: (errors) => {
            alert(Object.values(errors).join(', '));
        },
        onSuccess: () => {
            alert("Registro criado com sucesso!");
        }
    });
};
</script>

<template>
    <Layout>
        <Head title="Cadastrar Pessoa" />
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-4">Cadastrar Pessoa</h1>
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
                    <input
                    v-model="form.cpf" 
                    v-mask="'###.###.###-##'"
                    type="text" 
                    placeholder="CPF" 
                    class="border p-2 w-full" 
                    required />

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
                    <input 
                    v-model="form.telefone"
                    v-mask="'(##) #####-####'"
                    type="text" 
                    placeholder="Telefone" 
                    class="border p-2 w-full" />
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
                    {{ form.processing ? 'Salvando...' : 'Salvar' }}
                </button>
            </form>
        </div>
    </Layout>
</template>