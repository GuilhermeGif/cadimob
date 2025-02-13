<template>
    <div>
        <h1 class="text-2xl">Lista de Imóveis</h1>
        <table class="min-w-full table-auto mt-4">
        <thead>
            <tr>
            <th class="px-4 py-2">Inscrição Municipal</th>
            <th class="px-4 py-2">Tipo</th>
            <th class="px-4 py-2">Logradouro</th>
            <th class="px-4 py-2">Número</th>
            <th class="px-4 py-2">Bairro</th>
            <th class="px-4 py-2">Contribuinte</th>
            <th class="px-4 py-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="imovel in imoveis.data" :key="imovel.id">
            <td class="px-4 py-2">{{ imovel.id }}</td>
            <td class="px-4 py-2">{{ imovel.tipo }}</td>
            <td class="px-4 py-2">{{ imovel.logradouro }}</td>
            <td class="px-4 py-2">{{ imovel.numero }}</td>
            <td class="px-4 py-2">{{ imovel.bairro }}</td>
            <td class="px-4 py-2">{{ imovel.contribuinte.nome }}</td>
            <td class="px-4 py-2">
                <inertia-link :href="`/imoveis/${imovel.id}/edit`" class="text-blue-500">Editar</inertia-link>
                <button @click="deleteImovel(imovel.id)" class="text-red-500 ml-2">Excluir</button>
            </td>
            </tr>
        </tbody>
        </table>
    </div>
    </template>
    
    <script>
    export default {
    props: {
        imoveis: Object,
    },
    methods: {
        async deleteImovel(id) {
        if (confirm('Tem certeza que deseja excluir este imóvel?')) {
            this.$inertia.delete(`/imoveis/${id}`);
        }
        },
    },
};
</script>