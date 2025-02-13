<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { defineProps, computed } from "vue";

interface Imovel {
    id?: number;
    tipo: string;
    logradouro: string;
    numero: number | null;
    bairro: string;
    complemento?: string;
    area_terreno?: number | null;
    area_edificacao?: number | null;
    contribuinte_id: number | null;
}

interface Contribuinte {
    id: number;
    nome: string;
}

// Propriedades recebidas do backend
const props = defineProps<{
    imovel?: Imovel;
    contribuintes: Contribuinte[];
}>();


// Formulário com os dados do imóvel
const form = useForm({
    tipo: props.imovel?.tipo ?? "Terreno",
    logradouro: props.imovel?.logradouro ?? "",
    numero: props.imovel?.numero ?? null,
    bairro: props.imovel?.bairro ?? "",
    complemento: props.imovel?.complemento ?? "",
    area_terreno: props.imovel?.area_terreno ?? null,
    area_edificacao: props.imovel?.area_edificacao ?? null,
    contribuinte_id: props.imovel?.contribuinte_id ?? "",
});

// Computed para verificar se estamos editando ou criando um imóvel
const isEdit = computed(() => props.imovel?.id !== undefined);

// Submissão do formulário
const submitForm = () => {
    if (isEdit.value) {
    form.put(`/imoveis/${props.imovel.id}`, {
        onSuccess: () => alert("Imóvel atualizado com sucesso!"),
        onError: (errors) => (form.errors = errors),
    });
    } else {
    form.post("/imoveis", {
        onSuccess: () => alert("Imóvel cadastrado com sucesso!"),
        onError: (errors) => (form.errors = errors),
    });
    }
};

// Voltar para a página anterior
const voltar = () => {
    window.history.back();
};
</script>

<template>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">{{ isEdit ? "Editar" : "Cadastrar" }} Imóvel</h1>

    <form @submit.prevent="submitForm">
        <!-- Tipo do Imóvel -->
        <div class="mb-4">
        <label for="tipo" class="block font-medium">Tipo</label>
        <select v-model="form.tipo" id="tipo" class="input">
            <option value="Terreno">Terreno</option>
            <option value="Casa">Casa</option>
            <option value="Apartamento">Apartamento</option>
        </select>
        <p v-if="form.errors.tipo" class="text-red-500 text-sm">{{ form.errors.tipo }}</p>
        </div>

        <!-- Logradouro -->
        <div class="mb-4">
        <label for="logradouro" class="block font-medium">Logradouro</label>
        <input v-model="form.logradouro" type="text" id="logradouro" class="input" required />
        <p v-if="form.errors.logradouro" class="text-red-500 text-sm">{{ form.errors.logradouro }}</p>
        </div>

        <!-- Número -->
        <div class="mb-4">
        <label for="numero" class="block font-medium">Número</label>
        <input type="number" v-model="form.numero" id="numero" class="input" required />
        <p v-if="form.errors.numero" class="text-red-500 text-sm">{{ form.errors.numero }}</p>
        </div>

        <!-- Bairro -->
        <div class="mb-4">
        <label for="bairro" class="block font-medium">Bairro</label>
        <input type="text" v-model="form.bairro" id="bairro" class="input" required />
        <p v-if="form.errors.bairro" class="text-red-500 text-sm">{{ form.errors.bairro }}</p>
        </div>

        <!-- Complemento -->
        <div class="mb-4">
        <label for="complemento" class="block font-medium">Complemento</label>
        <input type="text" v-model="form.complemento" id="complemento" class="input" />
        </div>

        <!-- Área do Terreno -->
        <div class="mb-4">
        <label for="area_terreno" class="block font-medium">Área do Terreno (m²)</label>
        <input type="number" v-model="form.area_terreno" id="area_terreno" class="input" step="0.01" />
        </div>

        <!-- Área da Edificação -->
        <div class="mb-4">
        <label for="area_edificacao" class="block font-medium">Área da Edificação (m²)</label>
        <input type="number" v-model="form.area_edificacao" id="area_edificacao" class="input" step="0.01" />
        </div>

        <!-- Contribuinte -->
        <div class="mb-4">
        <label for="contribuinte_id" class="block font-medium">Proprietário (Contribuinte)</label>
        <select v-model="form.contribuinte_id" id="contribuinte_id" class="input" required>
            <option v-for="pessoa in props.contribuintes" :key="pessoa.id" :value="pessoa.id">
            {{ pessoa.nome }}
            </option>
        </select>
        <p v-if="form.errors.contribuinte_id" class="text-red-500 text-sm">{{ form.errors.contribuinte_id }}</p>
        </div>

        <!-- Botões -->
        <div class="flex justify-between mt-6">
        <button type="button" @click="voltar" class="px-4 py-2 bg-gray-500 text-white rounded">
            Cancelar
        </button>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded">
            {{ isEdit ? "Atualizar" : "Cadastrar" }}
        </button>
        </div>
    </form>
</div>
</template>

<style scoped>
.input {
    @apply w-full p-2 border rounded;
}
</style>
