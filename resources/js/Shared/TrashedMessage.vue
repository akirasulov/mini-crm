<template>
    <div
        class="flex max-w-3xl items-center justify-between rounded bg-red-600 p-4"
    >
        <div class="flex items-center">
            <TrashIcon class="mr-2 h-4 w-4 flex-shrink-0 text-white" />

            <div class="text-sm font-medium text-white">
                <slot />
            </div>
        </div>
        <button
            class="text-sm text-white hover:underline"
            tabindex="-1"
            type="button"
            @click="$emit('restore')"
        >
            Восстановить
        </button>
    </div>
</template>

<script setup>
import { TrashIcon } from "@heroicons/vue/24/solid";
defineEmits(["restore"]);
</script>
