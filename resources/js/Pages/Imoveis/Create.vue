<script setup>
import Layout from '@/Layouts/Layout.vue';
import { useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";

// Propriedades recebidas do backend
const props = defineProps({
    contribuintes: Array,
});

// Formulário vazio para criação de imóvel
const form = useForm({
    tipo: "",
    logradouro: "",
    numero: "",
    bairro: "",
    complemento: "",
    area_terreno: null,
    area_edificacao: null,
    contribuinte_id: null,
});

// Submissão do formulário
const submitForm = () => {
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