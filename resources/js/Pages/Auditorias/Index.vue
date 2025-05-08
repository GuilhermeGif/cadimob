<template>
    <Layout>
        <div class="p-6 bg-white rounded-lg shadow-md max-w-7xl mx-auto">
            <h1 class="text-3xl font-bold mb-6">Auditorias</h1>

                <!-- Filtros -->
            <form @submit.prevent="applyFilters" class="mb-6 flex flex-wrap gap-4">
                <input
                    type="text"
                    v-model="filters.usuario"
                    placeholder="Usuário"
                    class="border rounded px-3 py-2 flex-grow min-w-[150px]"
                />

                <input
                    type="text"
                    v-model="filters.evento"
                    placeholder="Evento"
                    class="border rounded px-3 py-2 flex-grow min-w-[150px]"
                />

                <input
                    type="date"
                    v-model="filters.data"
                    class="border rounded px-3 py-2"
                />

                <input
                    type="text"
                    v-model="filters.tabela"
                    placeholder="Tabela"
                    class="border rounded px-3 py-2 flex-grow min-w-[150px]"
                />

                <button
                    type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition"
                >Filtrar</button>
            </form>

            <!-- Tabela -->
            <div class="overflow-x-auto border border-gray-300 rounded">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuário</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evento</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data e horário</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tabela</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Auditado</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="audit in auditorias.data" :key="audit.id" class="hover:bg-gray-50">
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ audit.id }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ audit.user ? audit.user.name : 'Desconhecido' }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ eventMappingInverse[audit.event] || audit.event }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ new Date(audit.created_at).toLocaleDateString() }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ tableMappingInverse[audit.auditable_type] || audit.auditable_type }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ audit.auditable_id }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">
                                <button @click="openModal(audit)" class="text-indigo-600 hover:text-indigo-900">
                                    Detalhes
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="mt-6 flex justify-center">
                <nav class="inline-flex rounded-md shadow">
                    <Link 
                        v-for="(link, index) in auditorias.links" 
                        :key="index" 
                        :href="link.url || '#'" 
                        :class="{
                            'bg-blue-500 text-white': link.active,
                            'bg-white text-gray-700': !link.active
                        }" 
                        class="px-4 py-2 border rounded-md mx-1"
                        v-html="link.label"
                    />
                </nav>
            </div>

            <!-- Modal -->
        <div v-if="showModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
        <div 
            @click.stop 
            class="bg-white rounded-lg shadow-xl max-w-3xl w-full p-6 relative mx-4 sm:mx-0 max-h-[90vh] overflow-y-auto"
        >
            <!-- Botão Fechar -->
            <button 
            @click="showModal = false" 
            aria-label="Fechar modal"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition focus:outline-none"
            >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
            </button>

            <!-- Título -->
            <h2 class="text-2xl font-semibold mb-6 border-b pb-2">Detalhes da Auditoria #{{ currentAudit.id }}</h2>

            <!-- Conteúdo -->
            <div class="space-y-4 text-gray-700 text-sm sm:text-base">

            <div>
                <span class="font-semibold">Data:</span>
                {{ new Date(currentAudit.created_at).toLocaleString() }}
            </div>

            <div>
                <span class="font-semibold">Usuário:</span>
                {{ currentAudit.user ? currentAudit.user.name : 'Desconhecido' }}
            </div>

            <div>
                <span class="font-semibold">Evento:</span>
                {{ getMappedEvent(currentAudit.event) }}
            </div>

            <div>
                <span class="font-semibold">Tabela:</span>
                {{ getMappedTable(currentAudit.auditable_type) }}
            </div>

            <div>
                <span class="font-semibold">ID Auditado:</span>
                {{ currentAudit.auditable_id }}
            </div>

            <div>
                <span class="font-semibold">Dados Anteriores:</span>
                <pre class="bg-gray-100 rounded p-3 overflow-auto max-h-48 text-xs">{{ JSON.stringify(currentAudit.old_values, null, 2) }}</pre>
            </div>

            <div>
                <span class="font-semibold">Dados Novos:</span>
                <pre class="bg-gray-100 rounded p-3 overflow-auto max-h-48 text-xs">{{ JSON.stringify(currentAudit.new_values, null, 2) }}</pre>
            </div>

            <div>
                <span class="font-semibold">URL:</span>
                <a href="#" class="text-blue-600 underline break-all">{{ currentAudit.url }}</a>
            </div>

            <div>
                <span class="font-semibold">IP:</span>
                {{ currentAudit.ip_address }}
            </div>

            </div>
        </div>
    </div>
    </div>
    </Layout>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
import Layout from '@/Layouts/Layout.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    auditorias: Object,
});

const showModal = ref(false);
const currentAudit = ref({});

const eventMapping = {
    'Criação': 'created',
    'Exclusão': 'deleted',
    'Alteração': 'updated',
};

const tableMapping = {
    'Pessoas': 'App\\Models\\Pessoa',
    'Imóveis' : 'App\\Models\\Imovel',
    'Documentos' : 'App\\Models\\Documento',
    'Averbações' : 'App\\Models\\Averbacao',
    'Usuários' : 'App\\Models\\User',
}

const eventMappingInverse = {
    created: 'Criação',
    deleted: 'Exclusão',
    updated: 'Alteração',
}

const tableMappingInverse = {
    'App\\Models\\Pessoa': 'Pessoas',
    'App\\Models\\Imovel': 'Imóveis',
    'App\\Models\\Documento': 'Documentos',
    'App\\Models\\Averbacao': 'Averbações',
    'App\\Models\\User': 'Usuários',
}

const filters = ref({
    usuario: '',
    evento: '',
    data: '',
    tabela: '',
});

function getMappedEvent(event) {
    return eventMappingInverse[event] || event;
}

function getMappedTable(table) {
    return tableMappingInverse[table] || table;
}

function openModal(audit) {
    currentAudit.value = audit;
    showModal.value = true;
}

function applyFilters() {
    const event = eventMapping[filters.value.evento] || filters.value.evento
    const table = tableMapping[filters.value.tabela] || filters.value.table
    
    Inertia.get('/auditorias', {
        usuario: filters.value.usuario,
        evento: event,
        data: filters.value.data,
        tabela: table,
    }, { preserveState: true });
}

</script>