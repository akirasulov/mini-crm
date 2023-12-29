<template>
    <aside
        id="logo-sidebar"
        class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full border-r border-gray-200 bg-white pt-20 transition-transform sm:translate-x-0 dark:border-gray-700 dark:bg-gray-800"
        aria-label="Sidebar"
    >
        <div class="h-full overflow-y-auto bg-white px-3 pb-4 dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li v-for="(item, index) in navigation" :key="index">
                    <Link
                        :href="route(item.route)"
                        :class="{
                            'border border-blue-400': route().current(
                                item.route,
                            ),
                        }"
                        class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                    >
                        <component class="h-6 w-6" :is="item.icon" />
                        <span class="ms-3">{{ item.name }}</span>
                    </Link>
                </li>
            </ul>
        </div>
    </aside>
</template>

<script setup>
defineProps({
    navigation: {
        type: Array,
        required: true,
    },
});
</script>
