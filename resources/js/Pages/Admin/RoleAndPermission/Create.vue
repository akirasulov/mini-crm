<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import { Head } from "@inertiajs/vue3";
import Create from "./Partials/Store.vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title=" Роли и Разрешения" />

    <AuthenticatedLayout>
        <div class="h-screen">
            <div class="mx-auto max-w-7xl">
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
                >
                    <Create title="роль" route="role.store" />
                </div>
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
                >
                    <Create title="разрешение" route="permission.store" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
