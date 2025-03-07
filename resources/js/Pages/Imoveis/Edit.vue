<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";

// Propriedades recebidas do backend
const props = defineProps({
    imovel: Object,
    contribuintes: Array,
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
    form.put(route("imoveis.update", {id: props.imovel.id}), {
        onError: (errors) => {
            errorMessage.value = "Erro ao atualizar o registro."
        },
        onSuccess: () => {
            errorMessage.value = "";
        }
    });
};

// Voltar para a página anterior
const voltar = () => {
    window.history.back();
};

const errorMessage = ref("");
</script>

<template>
    <v-container>
        <v-card class="pa-6 rounded-xl shadow-md">
            <v-card-title class="text-h6 font-bold">Editar Imóvel</v-card-title>
            <v-card-text>
                <template v-if="imovel">
                    <v-form @submit.prevent="submitForm">
                        <v-select 
                            v-model="form.tipo" 
                            label="Tipo" 
                            :items="['Terreno', 'Casa', 'Apartamento']" 
                            required 
                            outlined 
                            dense 
                            :error-messages="form.errors.tipo"
                        />
                        <v-text-field 
                            v-model="form.logradouro" 
                            label="Logradouro" 
                            required 
                            outlined 
                            dense 
                            :error-messages="form.errors.logradouro"
                        />
                        <v-text-field 
                            v-model="form.numero" 
                            label="Número" 
                            required 
                            outlined 
                            dense 
                            :error-messages="form.errors.numero"
                        />
                        <v-text-field 
                            v-model="form.bairro" 
                            label="Bairro" 
                            required 
                            outlined 
                            dense 
                            :error-messages="form.errors.bairro"
                        />
                        <v-text-field 
                            v-model="form.complemento" 
                            label="Complemento" 
                            outlined 
                            dense 
                            :error-messages="form.errors.complemento"
                        />
                        <v-text-field 
                            v-model="form.area_terreno" 
                            label="Área do Terreno (m²)" 
                            type="number" 
                            required 
                            outlined 
                            dense 
                            :error-messages="form.errors.area_terreno"
                        />
                        <v-text-field 
                            v-model="form.area_edificacao" 
                            label="Área da Edificação (m²)" 
                            type="number" 
                            outlined 
                            dense 
                            :error-messages="form.errors.area_edificacao"
                        />
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

                        <v-alert v-if="errorMessage" type="error" class="mt-2">
                            {{ errorMessage }}
                        </v-alert>
                        
                        <v-btn :loading="form.processing" color="blue" type="submit" class="mt-4 mr-2">
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
</template>