
<template>
    <v-container>
        <v-card class="pa-5">
            <v-form @submit.prevent="submit">
                <v-text-field label="Nome" v-model="form.nome" required></v-text-field>
                <v-text-field label="Data de Nascimento" v-model="form.data_nascimento" required></v-text-field>
                <v-text-field label="CPF" v-model="form.cpf" required></v-text-field>

                <v-select
                    label="Sexo"
                    v-model="form.sexo"
                    :items="['Masculino', 'Feminino']"
                    required
                ></v-select>
                
                <v-text-field label="Telefone" v-model="form.telefone"></v-text-field>
                <v-text-field label="E-mail" v-model="form.email" type="email" required></v-text-field>

                <v-btn type="submit" color="primary">Cadastrar</v-btn>
            </v-form>
        </v-card>

        <v-card class="mt-5">
            <v-list>
                <v-list-item v-for="pessoa in pessoas" :key="pessoa.id">
                    {{ pessoa.nome }} - {{ pessoa.email }}
                </v-list-item>
            </v-list>
        </v-card>
    </v-container>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'

defineProps({ pessoas: Array });

const form = ref({
    nome: '',
    data_nascimento: '',
    cpf: '',
    sexo: '',
    telefone: '',
    email: ''
});

const submit = () => {
    router.post('/pessoas', form.value);
};
</script>