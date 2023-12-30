<script setup>
import ThemeToogle from "@/Components/ThemeToogle.vue";
</script>

<template>
    <ThemeToogle class="absolute right-10 top-10" />
    <main>
        <slot />
    </main>
</template>
