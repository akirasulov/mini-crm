<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePermission } from "@/Composables/permissions";
const { checkpermission } = usePermission();
</script>

<template>
    <Head title="Главная" />
    <AuthenticatedLayout v-if="!checkpermission.isClient"></AuthenticatedLayout>
</template>
