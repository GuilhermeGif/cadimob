<template>
    <v-container>
        <v-card class="pa-6 rounded-xl shadow-md">
        <v-card-title class="text-h6 font-bold">Editar Pessoa</v-card-title>
        <v-card-text>
            <v-form @submit.prevent="submitForm">
            <v-text-field 
                v-model="form.nome" 
                label="Nome" 
                required 
                outlined 
                dense 
            />
            <v-text-field 
                v-model="form.data_nascimento" 
                label="Data de Nascimento" 
                type="date" 
                required 
                outlined 
                dense 
            />
            <v-text-field 
                v-model="form.cpf" 
                label="CPF" 
                required 
                outlined 
                dense 
            />
            <v-select 
                v-model="form.sexo" 
                label="Sexo" 
                :items="['Masculino', 'Feminino']" 
                required 
                outlined 
                dense 
            />
            <v-text-field 
                v-model="form.telefone" 
                label="Telefone" 
                outlined 
                dense 
            />
            <v-text-field 
                v-model="form.email" 
                label="E-mail" 
                type="email" 
                outlined 
                dense 
            />

            <v-alert v-if="errorMessage" type="error" class="mt-2">
                {{ errorMessage }}
            </v-alert>
            
            <button :loading="form.processing" type="submit" class="bg-blue-500 text-white hover:bg-blue-700 px-5 py-2 mr-2 rounded-md justify-between">
                Salvar
            </button>
            <button @click="voltar" class="bg-gray-400 text-white hover:bg-gray-600 px-5 py-2 mr-2 rounded-md justify-between">
                Voltar
            </button>
            </v-form>
        </v-card-text>
        </v-card>
    </v-container>
    </template>
    
    <script setup>
    import { ref } from "vue";
    import { useForm } from "@inertiajs/vue3";
    
    const props = defineProps({
    pessoa: Object,
});

    const errorMessage = ref("");

    const form = useForm({
    nome: props.pessoa.nome || "",
    data_nascimento: props.pessoa.data_nascimento || "",
    cpf: props.pessoa.cpf || "",
    sexo: props.pessoa.sexo || "",
    telefone: props.pessoa.telefone || "",
    email: props.pessoa.email || "",
});

    const submitForm = () => {
    form.put(route("pessoas.update", props.pessoa.id), {
        onError: (errors) => {
        errorMessage.value = "Erro ao atualizar o registro!";
    },
        onSuccess: () => {
        errorMessage.value = "";
        },
    });
};

    const voltar = () => {
        window.history.back();
};
</script>
