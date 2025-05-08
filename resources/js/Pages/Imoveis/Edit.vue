<script setup>
import Layout from '@/Layouts/Layout.vue';
import { useForm } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";
import axios from 'axios';

// Propriedades recebidas do backend
const props = defineProps({
    imovel: Object,
    contribuintes: Array,
    documentos: Array, 
});

// Verifica se o imóvel está definido
const imovel = computed(() => props.imovel || {});

// Formulário preenchido com os dados do imóvel
const form = useForm({
    tipo: props.imovel.tipo || "",
    logradouro: props.imovel.logradouro || "",
    numero: props.imovel.numero || "",
    bairro: props.imovel.bairro || "",
    complemento: props.imovel.complemento || "",
    area_terreno: props.imovel.area_terreno || null,
    area_edificacao: props.imovel.area_edificacao || null,
    contribuinte_id: props.imovel.contribuinte_id || null,
});

// Submissão do formulário
const submitForm = () => {
    form.put(route("imoveis.update", { id: props.imovel.id }), {
        onError: (errors) => {
            errorMessage.value = "Erro ao atualizar o registro.";
        },
        onSuccess: () => {
            errorMessage.value = "";
        },
    });
}

// Voltar para a página anterior
const voltar = () => {
    window.history.back();
};

const errorMessage = ref("");

// Gerenciamento de documentos
const documentos = ref(props.documentos || []); // Lista de documentos anexados
const arquivos = ref([]); // Arquivos selecionados para upload

watch(() => props.documentos, (newDocumentos) => {
    documentos.value = newDocumentos || [];
});

// Função para lidar com a seleção de arquivos
const handleFileChange = (event) => {
    arquivos.value = event.target.files;
};

// Função para enviar documentos ao backend
const uploadDocumentos = async () => {
    try {
        const formData = new FormData();

        // Adiciona os arquivos ao FormData
        for (let i = 0; i < arquivos.value.length; i++) {
            formData.append('documentos[]', arquivos.value[i]);
        }

        // Envia a requisição
        const response = await axios.post(`/imoveis/${props.imovel.id}/documentos`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        // Atualiza a lista de documentos
        documentos.value = response.data.documentos;
        arquivos.value = []; // Limpa os arquivos selecionados
        errorMessage.value = "";
    } catch (error) {
        console.error(error);
        errorMessage.value = error.response?.data?.message || "Erro ao enviar documentos.";
    }
};

// Função para excluir um documento
const excluirDocumento = async (documentoId) => {
    try {
        await axios.delete(`/documentos/${documentoId}`);
        documentos.value = documentos.value.filter(doc => doc.id !== documentoId); // Remove o documento da lista
        errorMessage.value = "";
    } catch (error) {
        console.error(error);
        errorMessage.value = error.response?.data?.error || "Erro ao excluir o documento.";
    }
};

// Função para baixar um documento
const baixarDocumento = (documentoId) => {
    window.location.href = `/documentos/${documentoId}/download`;
};
</script>

<template>
    <Layout>
        <v-container>
            <v-card class="pa-6 rounded-xl shadow-md">
                <v-card-title class="text-h6 font-bold">Editar Imóvel</v-card-title>
                <v-card-title>
                    <v-btn
                    rounded="xs"
                    color="blue"
                    size="large"
                    variant="tonal"
                    class="me-2"
                    :href="route('averbacoes.index', props.imovel.id)"
                    >
                    Visualizar Averbações
                    </v-btn>
                    <v-btn
                    rounded="xs"
                    color="blue"
                    size="large"
                    variant="tonal"
                    class="me-2"
                    :href="route('relatorios.individual', props.imovel.id)"
                    >Relatório Individual</v-btn>
                </v-card-title>
                <v-card-text>
                    <template v-if="imovel">
                        <v-form @submit.prevent="submitForm">
                            <!-- Tipo de Imóvel -->
                            <v-select 
                                v-model="form.tipo" 
                                label="Tipo" 
                                :items="['Terreno', 'Casa', 'Apartamento']" 
                                required 
                                outlined 
                                dense 
                                :error-messages="form.errors.tipo"
                            />

                            <!-- Logradouro -->
                            <v-text-field 
                                v-model="form.logradouro" 
                                label="Logradouro" 
                                required 
                                outlined 
                                dense 
                                :error-messages="form.errors.logradouro"
                            />

                            <!-- Número -->
                            <v-text-field 
                                v-model="form.numero" 
                                label="Número" 
                                required 
                                outlined 
                                dense 
                                :error-messages="form.errors.numero"
                            />

                            <!-- Bairro -->
                            <v-text-field 
                                v-model="form.bairro" 
                                label="Bairro" 
                                required 
                                outlined 
                                dense 
                                :error-messages="form.errors.bairro"
                            />

                            <!-- Complemento -->
                            <v-text-field 
                                v-model="form.complemento" 
                                label="Complemento" 
                                outlined 
                                dense 
                                :error-messages="form.errors.complemento"
                            />

                            <!-- Área do Terreno -->
                            <v-text-field 
                                v-model="form.area_terreno" 
                                label="Área do Terreno (m²)" 
                                type="number" 
                                outlined 
                                dense 
                                :error-messages="form.errors.area_terreno"
                            />

                            <!-- Área da Edificação -->
                            <v-text-field 
                                v-model="form.area_edificacao" 
                                label="Área da Edificação (m²)" 
                                type="number" 
                                outlined 
                                dense 
                                :error-messages="form.errors.area_edificacao"
                            />
                            
                            <!-- Contribuinte -->
                            <v-select
                                v-model="form.contribuinte_id"
                                label="Contribuinte"
                                :items="contribuintes"
                                item-title="nome"
                                item-value="id"
                                required
                                outlined
                                dense
                                :error-messages="form.errors.contribuinte_id"
                            />

                            <!-- Situação -->
                            <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Situação</label>
                            <div class="flex items-center">
                                <span
                                :style="{
                                    display: 'inline-block',
                                    width: '16px',
                                    height: '16px',
                                    borderRadius: '50%',
                                    backgroundColor: imovel.situacao === 'Ativo' ? '#22c55e' : '#ef4444', // verde ou vermelho
                                    marginRight: '8px'
                                }"
                                ></span>
                                <!-- Opcionalmente, remova o texto abaixo para mostrar só o ícone -->
                                <span class="text-sm">{{ imovel.situacao }}</span>
                            </div>
                            </div>
                            <!-- Upload de documentos -->
                            <div class="mb-4">
                                <label for="documentos" class="block text-sm font-medium text-gray-700">Anexar Documentos</label>
                                <input 
                                    type="file" 
                                    id="documentos" 
                                    multiple 
                                    @change="handleFileChange" 
                                    accept=".jpg,.jpeg,.png,.pdf" 
                                    class="border p-2 w-full"
                                />
                                <v-btn @click="uploadDocumentos" color="primary" class="mt-2">Enviar Documentos</v-btn>
                            </div>

                            <!-- Lista de documentos anexados -->
                            <div v-if="documentos.length > 0" class="mt-4">
                                <h3 class="text-lg font-semibold mb-2">Documentos Anexados</h3>
                                <ul>
                                <li
                                    v-for="documento in documentos"
                                    :key="documento.id"
                                    class="flex items-center justify-between mb-2 border rounded p-2"
                                >
                                    <span class="flex-1 mr-4 truncate">{{ documento.nome_arquivo }}</span>
                                    <div class="flex space-x-2">
                                    <button
                                        @click="baixarDocumento(documento.id)"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded"
                                        type="button"
                                    >
                                        Baixar
                                    </button>
                                    <button
                                        @click="excluirDocumento(documento.id)"
                                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded"
                                        type="button"
                                    >
                                        Excluir
                                    </button>
                                    </div>
                                </li>
                                </ul>
                            </div>

                            <!-- Mensagem de erro -->
                            <v-alert v-if="errorMessage" type="error" class="mt-2">
                                {{ errorMessage }}
                            </v-alert>

                            <!-- Botões -->
                            <v-btn :loading="form.processing" color="blue" type="submit" class="mt-4 me-2">
                                Salvar
                            </v-btn>
                            <v-btn @click="voltar" color="grey" class="mt-4">
                                Voltar
                            </v-btn>
                        </v-form>
                    </template>
                    <v-alert v-else type="error" class="mt-2">
                        Imóvel não encontrado.
                    </v-alert>
                </v-card-text>
            </v-card>
        </v-container>
    </Layout>
</template>