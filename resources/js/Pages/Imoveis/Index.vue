<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Link, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";

// Definição das props
const props = defineProps({
    imoveis: Object,
});

// Variáveis reativas para os filtros
const inscricaoMunicipal = ref('');
const tipo = ref('');
const logradouro = ref('');
const numero = ref('');
const bairro = ref('');
const contribuinte = ref('');
const situacao = ref('');

// Computed para filtrar os imóveis
const filteredImoveis = computed(() => {
    console.log("Filtrando imóveis..."); // Diagnóstico
    console.log("Dados de imóveis:", props.imoveis.data); // Verifique os dados

    return props.imoveis.data.filter(imovel => {
        return (
            (inscricaoMunicipal.value === '' || imovel.id.toString().includes(inscricaoMunicipal.value)) &&
            (tipo.value === '' || imovel.tipo.toLowerCase().includes(tipo.value.toLowerCase())) &&
            (logradouro.value === '' || imovel.logradouro.toLowerCase().includes(logradouro.value.toLowerCase())) &&
            (numero.value === '' || (imovel.numero && imovel.numero.toString().includes(numero.value))) &&
            (bairro.value === '' || imovel.bairro.toLowerCase().includes(bairro.value.toLowerCase())) &&
            (contribuinte.value === '' || (imovel.contribuinte && imovel.contribuinte.nome.toLowerCase().includes(contribuinte.value.toLowerCase()))) &&
            (situacao.value === '' || (imovel.situacao && imovel.situacao.toLowerCase().includes(situacao.value.toLowerCase())))
        );
    });
});

// Função para deletar imóvel com feedback visual
const deleteImovel = (id) => {
    if (confirm("Tem certeza que deseja excluir este imóvel?")) {
        router.delete(route('imoveis.destroy', id), {
            preserveScroll: true,
            onSuccess: () => alert("Imóvel excluído com sucesso!"),
            onError: (errors) => alert("Erro ao excluir o imóvel."),
        });
    }
};
</script>

<template>
    <Layout>
        <div class="max-w-6xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Lista de Imóveis</h1>
                <Link
                    href="/imoveis/create"
                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700 transition"
                >
                    + Cadastrar Imóvel
                </Link>
            </div>

            <v-btn
            rounded="xs" 
                                color="blue"
                                size="large"
                                prepend-icon="mdi-file-download-outline"
                                variant="tonal" 
                                class="me-2"
                                :href="route('relatorios.sintetico')" 
                                target="_blank">
                                    Emitir Relatório
            ></v-btn>

            <!-- Formulário de Filtro -->
            <div class="mb-4">
                <input v-model="inscricaoMunicipal" type="text" placeholder="Inscrição Municipal" class="border p-2 mr-2" />
                <input v-model="tipo" type="text" placeholder="Tipo" class="border p-2 mr-2" />
                <input v-model="logradouro" type="text" placeholder="Logradouro" class="border p-2 mr-2" />
                <input v-model="numero" type="text" placeholder="Número" class="border p-2 mr-2" />
                <input v-model="bairro" type="text" placeholder="Bairro" class="border p-2 mr-2" />
                <input v-model="contribuinte" type="text" placeholder="Contribuinte" class="border p-2 mr-2" />
                <input v-model="situacao" type="text" placeholder="Situação" class="border p-2" />
            </div>

            <div class="overflow-x-auto">
                <table class="w-full table-auto border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border">Inscrição Municipal</th>
                            <th class="px-4 py-2 border">Tipo</th>
                            <th class="px-4 py-2 border">Logradouro</th>
                            <th class="px-4 py-2 border">Número</th>
                            <th class="px-4 py-2 border">Bairro</th>
                            <th class="px-4 py-2 border">Contribuinte</th>
                            <th class="px-4 py-2 border">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="imovel in filteredImoveis" :key="imovel.id" class="hover:bg-gray-50">
                            <td class="px-4 py-2 border text-center">{{ imovel.id }}</td>
                            <td class="px-4 py-2 border">{{ imovel.tipo }}</td>
                            <td class="px-4 py-2 border">{{ imovel.logradouro }}</td>
                            <td class="px-4 py-2 border text-center">{{ imovel.numero ?? "N/A" }}</td>
                            <td class="px-4 py-2 border">{{ imovel.bairro }}</td>
                            <td class="px-4 py-2 border">
                                {{ imovel.contribuinte ? imovel.contribuinte.nome : "Desconhecido" }}
                            </td>
                            <td class="px-4 py-2 border flex gap-2 justify-center">
                                <Link
                                    :href="`/imoveis/${imovel.id}/edit`"
                                    class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
                                >
                                    Editar
                                </Link>
                                <button
                                    @click="deleteImovel(imovel.id)"
                                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition"
                                >
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div v-if="imoveis.links" class="mt-4 flex justify-center space-x-2">
                <Link
                    v-for="link in imoveis.links"
                    :key="link.label"
                    :href="link.url"
                    v-html="link.label"
                    class="px-3 py-1 border rounded"
                    :class="{ 'bg-blue-500 text-white': link.active }"
                ></Link>
            </div>
        </div>
    </Layout>
</template>