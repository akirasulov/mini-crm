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
                        v-if="item.can"
                        :href="route(item.route)"
                        :class="{
                            'border border-blue-400': route().current(
                                item.route,
                            ),
                        }"
                        class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                    >
                        <component class="size-6" :is="item.icon" />
                        <span class="ms-3">{{ item.name }}</span>
                    </Link>
                </li>
                <li v-if="checkpermission.isAdmin">
                    <button
                        type="button"
                        class="group flex w-full items-center rounded-lg p-2 text-base font-normal text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        aria-controls="dropdown-pages"
                        data-collapse-toggle="dropdown-pages"
                    >
                        <PrinterIcon class="size-6" />

                        <span class="ml-3 flex-1 whitespace-nowrap text-left"
                            >Отчеты</span
                        >
                        <svg
                            aria-hidden="true"
                            class="h-6 w-6"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </button>
                    <ul id="dropdown-pages" class="hidden space-y-2 py-2">
                        <li>
                            <a
                                href="#"
                                class="group flex w-full items-center rounded-lg p-2 pl-11 text-base font-normal text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                >Пользователи</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="group flex w-full items-center rounded-lg p-2 pl-11 text-base font-normal text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                >Обращения</a
                            >
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </aside>
</template>

<script setup>
import { initDropdowns } from "flowbite";
import { onMounted } from "vue";
import { PrinterIcon } from "@heroicons/vue/24/solid";
import { usePermission } from "@/Composables/permissions";
const { checkpermission } = usePermission();
onMounted(() => {
    initDropdowns();
});
defineProps({
    navigation: {
        type: Array,
        required: true,
    },
});
</script>
