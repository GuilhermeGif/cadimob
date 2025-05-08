<script setup>
import Layout from '@/Layouts/Layout.vue';
import { useForm, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";

// Propriedades recebidas do backend
const props = defineProps({
    contribuintes: Array,
    documentos: Array,
});

// Formulário vazio para criação de imóvel
const form = useForm({
    tipo: props.imovel?.tipo || "",
    logradouro: props.imovel?.logradouro || "",
    numero: props.imovel?.numero || "",
    bairro: props.imovel?.bairro || "",
    complemento: props.imovel?.complemento || "",
    area_terreno: props.imovel?.area_terreno || null,
    area_edificacao: props.imovel?.area_edificacao ?? null,
    contribuinte_id: props.imovel?.contribuinte_id || null,
    situacao: props.imovel?.situacao || "Ativo",
    documentos: [],
});

// Submissão do formulário
const submitForm = () => {

    form.area_edificacao = Number(form.area_edificacao);
    form.area_terreno = Number(form.area_terreno);

    console.log(form);

    form.post(route("imoveis.store"), {
        onError: (errors) => {
            errorMessage.value = "Erro ao cadastrar o imóvel.";
        },
        onSuccess: () => {
            errorMessage.value = "Imóvel cadastrado com sucesso!";
        },
    });

    form.post(route("imoveis.store"), {
        onError: (errors) => {
            errorMessage.value = "Erro ao cadastrar o imóvel.";
        },
        onSuccess: () => {
            errorMessage.value = "";
        },
    });
};

// Voltar para a página anterior
const voltar = () => {
    window.history.back();
};

const errorMessage = ref("");

const documentos = ref([]); // Lista de documentos anexados
const arquivos = ref([]); // Arquivos selecionados para upload

const handleFileChange = (event) => {
    documentos.value = event.target.files;
};

const uploadDocumentos = async () => {
    const formData = new FormData();
    for (let i = 0; i < documentos.value.length; i++) {
        formData.append('documentos[]', documentos.value[i]);
    }

    await axios.post(`/imoveis/${props.imovel.id}/documentos`, formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    }).then(response => {
        documentos.value = response.data.documentos; // Atualiza a lista de documentos
    }).catch(error => {
        console.error(error);
    });
};

const excluirDocumento = (documentoId) => {
    axios.delete(`/documentos/${documentoId}`).then(() => {
        documentos.value = documentos.value.filter(doc => doc.id !== documentoId); // Remove o documento da lista
    });
};

const baixarDocumento = (documentoId) => {
    window.location.href = `/documentos/${documentoId}/download`;
};


</script>

<template>
    <Layout>
        <v-container>
            <v-card class="pa-6 rounded-xl shadow-md">
                <v-card-title class="text-h6 font-bold">Cadastrar Imóvel</v-card-title>
                <v-card-text>
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

                        <!-- Upload de documentos -->
                        <div class="mb-4">
                            <label for="documentos" class="block text-sm font-medium text-gray-700">Documentos</label>
                            <input 
                                type="file" 
                                id="documentos" 
                                multiple 
                                @change="handleFileChange" 
                                accept=".jpg,.jpeg,.png,.pdf" 
                                class="border p-2 w-full"
                            />
                            <span v-if="form.errors.documentos" class="text-red-500 text-sm">{{ form.errors.documentos }}</span>
                        </div>

                        <!-- Lista de documentos anexados -->
                        <div v-if="documentos.length > 0" class="mt-4">
                            <h3 class="text-lg font-semibold mb-2">Documentos Anexados</h3>
                            <ul>
                                <li v-for="documento in documentos" :key="documento.id" class="flex justify-between items-center mb-2">
                                    <span>{{ documento.nome }}</span>
                                    <div>
                                        <v-btn @click="baixarDocumento(documento.id)" color="primary" small class="mr-2">Baixar</v-btn>
                                        <v-btn @click="excluirDocumento(documento.id)" color="error" small>Excluir</v-btn>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Mensagem de erro -->
                        <v-alert v-if="errorMessage" type="error" class="mt-2">
                            {{ errorMessage }}
                        </v-alert>

                        <!-- Botões -->
                        <v-btn :loading="form.processing" color="blue" type="submit" class="mt-4 mr-2">
                            Salvar
                        </v-btn>
                        <v-btn @click="voltar" color="grey" class="mt-4">
                            Voltar
                        </v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-container>
    </Layout>
</template>