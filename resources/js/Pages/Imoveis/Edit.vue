<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

interface Imovel {
    id: number;
    tipo: string;
    logradouro: string;
    numero: number | null;
    bairro: string;
    complemento?: string;
    area_terreno?: number | null;
    area_edificacao?: number | null;
    contribuinte_id: number;
}

interface Contribuinte {
    id: number;
    nome: string;
}

// Propriedades recebidas do backend
const props = defineProps<{
    imovel: Imovel;
    contribuintes: Contribuinte[];
}>();

// Formulário preenchido com os dados do imóvel
const form = useForm({
    tipo: props.imovel.tipo,
    logradouro: props.imovel.logradouro,
    numero: props.imovel.numero,
    bairro: props.imovel.bairro,
    complemento: props.imovel.complemento ?? "",
    area_terreno: props.imovel.area_terreno ?? null,
    area_edificacao: props.imovel.area_edificacao ?? null,
    contribuinte_id: props.imovel.contribuinte_id,
});

// Submissão do formulário
const submitForm = () => {
    form.put(`/imoveis/${props.imovel.id}`, {
        onSuccess: () => alert("Imóvel atualizado com sucesso!"),
        onError: (errors) => (form.errors = errors),
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
                <v-form @submit.prevent="submitForm">
                    <v-select 
                        v-model="form.tipo" 
                        label="Tipo" 
                        :items="['Terreno', 'Casa', 'Apartamento']" 
                        required 
                        outlined 
                        dense 
                    />
                    <v-text-field 
                        v-model="form.logradouro" 
                        label="Logradouro" 
                        required 
                        outlined 
                        dense 
                    />
                    <v-text-field 
                        v-model="form.numero" 
                        label="Número" 
                        required 
                        outlined 
                        dense 
                    />
                    <v-text-field 
                        v-model="form.bairro" 
                        label="Bairro" 
                        required 
                        outlined 
                        dense 
                    />
                    <v-text-field 
                        v-model="form.complemento" 
                        label="Complemento" 
                        outlined 
                        dense 
                    />
                    <v-text-field 
                        v-model="form.area_terreno" 
                        label="Área do Terreno (m²)" 
                        type="number" 
                        required 
                        outlined 
                        dense 
                    />
                    <v-text-field 
                        v-model="form.area_edificacao" 
                        label="Área da Edificação (m²)" 
                        type="number" 
                        outlined 
                        dense 
                    />
                    <v-text-field 
                        v-model="form.contribuinte_id" 
                        label="Contribuinte (ID)" 
                        required 
                        outlined 
                        dense 
                    />
                    
                    <v-alert v-if="errorMessage" type="error" class="mt-2">
                        {{ errorMessage }}
                    </v-alert>
                    
                    <v-btn :loading="form.processing" color="blue" type="submit" class="mt-4 mr-2">
                        Salvar
                    </v-btn>
                </v-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>
