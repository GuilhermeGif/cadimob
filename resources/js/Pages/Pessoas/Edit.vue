<template>
    <div>
        <form @submit.prevent="submitForm">
        <div>
            <label for="nome">Nome</label>
            <input v-model="form.nome" type="text" required />
        </div>
        
        <div>
            <label for="data_nascimento">Data de Nascimento</label>
            <input v-model="form.data_nascimento" type="date" required />
        </div>
        
        <div>
            <label for="cpf">CPF</label>
            <input v-model="form.cpf" type="text" required />
        </div>
        
        <div>
            <label for="sexo">Sexo</label>
            <select v-model="form.sexo" required>
            <option value="masculino">Masculino</option>
            <option value="feminino">Feminino</option>
            </select>
        </div>
        
        <!-- Outros campos aqui, que são opcionais -->
        
        <button type="submit" class="bg-blue-500 text-white px-4 py-4 rounded-md">Salvar</button>
        </form>
    </div>
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