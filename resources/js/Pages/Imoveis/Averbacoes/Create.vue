<template>
    <Layout>
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-4">Criar Averbação</h1>
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="evento" class="block text-sm font-medium text-gray-700">Evento</label>
                    <select v-model="form.evento" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="Aumento Área Construída">Aumento Área Construída</option>
                        <option value="Redução Área Construída">Redução Área Construída</option>
                        <option value="Observação">Observação</option>
                        <option value="Cancelamento">Cancelamento</option>
                        <option value="Reativação">Reativação</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="medida" class="block text-sm font-medium text-gray-700">Medida (m²)</label>
                    <input type="number" v-model="form.medida" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                </div>
                <div class="mb-4">
                    <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
                    <textarea v-model="form.descricao" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2 rounded-md hover:bg-indigo-700 transition duration-200">Salvar</button>
            </form>
        </div>
    </Layout>
</template>

<script setup>

import { useForm } from "@inertiajs/vue3";
import Layout from '@/Layouts/Layout.vue';
import { ref } from 'vue';


const props = defineProps({
    imovel_id: {
        type: Number,
    }
});

const form = useForm({
    evento:'',
    medida: null,
    descricao: '',
    imovel_id: props.imovel_id, 
});

const submit = () => {
    form.post(route('averbacoes.store'), {
        onSuccess: () => {
            'Averbação registrada com sucesso!'
        },
        onError: () => {
            'Não foi possível registrar a averbação.'
        },
    });
};

</script>