<script setup>
    const props = defineProps ({
        imovel: Object,
        averbacoes: Array,
        errors: Object,
        auth: Object,
        flash: Object
    })

    const emit = defineEmits(['close'])

    const formatDate = (dateString) => {
        let [ano, mes, dia] = dateString.split('-')
        return `${dia}/${mes}/${ano}`
    }
</script>

<template>
    
</template>