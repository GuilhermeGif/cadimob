<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { defineProps } from "vue";

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
</script>

<template>
    <create :form="form" :submitForm="submitForm" :voltar="voltar" />
</template>
