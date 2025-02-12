<template>
    <form @submit.prevent="submitForm">
        <input v-model="form.nome" type="text" required />
        <input v-model="form.data_nascimento" type="date" required />
        <input v-model="form.cpf" type="text" required />
        <select v-model="form.sexo" required>
        <option value="Masculino">Masculino</option>
        <option value="Feminino">Feminino</option>
        </select>    
        <button type="submit" class="bg-blue-500 text-white px-4 py-4 rounded-md">Salvar</button>
    </form>
    </template>
    
    <script setup>
    import { useForm } from '@inertiajs/vue3';
    
    const props = defineProps({
        pessoa: Object,
});

    const form = useForm({
        nome: props.pessoa.nome || '',
        data_nascimento: props.pessoa.data_nascimento || '',
        cpf: props.pessoa.cpf || '',
        sexo: props.pessoa.sexo || '',
        telefone: props.pessoa.telefone || '',
        email: props.pessoa.email || '',
      // outros campos opcionais
});

const submitForm = () => {
    form.put(route('pessoas.update', props.pessoa.id), {
        onFinish: () => {
            alert('Registro atualizado com sucesso!');
        },
        onError: () => {
            alert('Erro ao atualizar o registro no sistema.');
        }
    });
}
</script>