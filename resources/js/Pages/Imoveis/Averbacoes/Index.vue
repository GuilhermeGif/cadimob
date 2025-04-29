<template>
    <Layout>
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Averbações</h1>
                <Link 
                    :href="`/imoveis/${imovel_id}/averbacoes/create`" 
                    class="bg-indigo-600 text-white font-bold py-2 px-4 rounded-md hover:bg-indigo-700 transition duration-200">
                    + Criar Nova Averbação
                </Link>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:w-1/4 lg:w-1/3">Evento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:w-1/6 lg:w-1/5">Medida (m²)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:w-2/4 lg:w-2/3">Descrição</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider md:w-1/4 lg:w-1/3">Data</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="averbacao in averbacoes" :key="averbacao.id">
                        <td class="px-6 py-4 whitespace-normal text-sm text-gray-900 break-words">{{ averbacao.evento }}</td>
                        <td class="px-6 py-4 whitespace-normal text-sm text-gray-900 break-words">{{ averbacao.medida }}</td>
                        <td class="px-6 py-4 whitespace-normal text-sm text-gray-900 break-words">{{ averbacao.descricao }}</td>
                        <td class="px-6 py-4 whitespace-normal text-sm text-gray-900 break-words">{{ new Date(averbacao.data_averbacao).toLocaleDateString('pt-BR') }}</td>
                    </tr>
                </tbody>
            </table>
            <div v-if="!averbacoes.length" class="mt-4 text-center text-gray-500">Nenhuma averbação encontrada.</div>
        </div>
    </Layout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import Layout from '@/Layouts/Layout.vue';

defineProps({
    averbacoes: Array,
    imovel_id: Number,
});
</script>