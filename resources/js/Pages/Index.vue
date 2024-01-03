<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePermission } from "@/Composables/permissions";
const { checkpermission } = usePermission();

defineProps({
    posts: Object,
});
</script>

<template>
    <Head title="Главная" />
    <AuthenticatedLayout>
        <template v-if="checkpermission.isClient">
            <pre>{{ posts }}</pre>
            <section class="bg-gray-50 p-3 sm:p-5 dark:bg-gray-900">
                <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                    <div
                        class="relative overflow-hidden bg-white shadow-md sm:rounded-lg dark:bg-gray-800"
                    >
                        <div class="overflow-x-auto">
                            <table
                                class="w-full text-left text-sm text-gray-500 dark:text-gray-400"
                            >
                                <thead
                                    class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400"
                                >
                                    <tr>
                                        <th scope="col" class="px-4 py-3">
                                            Product name
                                        </th>
                                        <th scope="col" class="px-4 py-3">
                                            Category
                                        </th>
                                        <th scope="col" class="px-4 py-3">
                                            Brand
                                        </th>
                                        <th scope="col" class="px-4 py-3">
                                            Description
                                        </th>
                                        <th scope="col" class="px-4 py-3">
                                            Price
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b dark:border-gray-700">
                                        <th
                                            scope="row"
                                            class="whitespace-nowrap px-4 py-3 font-medium text-gray-900 dark:text-white"
                                        >
                                            Apple iMac 27&#34;
                                        </th>
                                        <td class="px-4 py-3">PC</td>
                                        <td class="px-4 py-3">Apple</td>
                                        <td class="px-4 py-3">300</td>
                                        <td class="px-4 py-3">$2999</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </template>
        <template v-else>
            <section class="bg-white antialiased dark:bg-gray-900">
                <div
                    class="mx-auto max-w-screen-xl px-4 py-8 sm:py-16 lg:px-6 lg:py-24"
                >
                    <div class="mx-auto max-w-2xl text-center">
                        <h2
                            class="text-3xl font-extrabold leading-tight tracking-tight text-gray-900 sm:text-4xl dark:text-white"
                        >
                            Система управления взаимоотношениями с клиентами
                        </h2>
                    </div>

                    <div
                        class="mt-12 grid grid-cols-1 gap-x-20 gap-y-12 text-center sm:mt-16 sm:grid-cols-2 lg:grid-cols-3"
                    >
                        <div class="space-y-4">
                            <h3
                                class="text-2xl font-bold leading-tight text-gray-900 dark:text-white"
                            >
                                Управление информацией о клиентах
                            </h3>
                            <p
                                class="text-lg font-normal text-gray-500 dark:text-gray-400"
                            >
                                Одна из главных функций CRM-системы — помогать
                                менеджерам планировать продажи, организовывать
                                прозрачное управление сделками и оптимизировать
                                каналы продаж.
                            </p>
                        </div>

                        <div class="space-y-4">
                            <h3
                                class="text-2xl font-bold leading-tight text-gray-900 dark:text-white"
                            >
                                Планирование и контроль продаж
                            </h3>
                            <p
                                class="text-lg font-normal text-gray-500 dark:text-gray-400"
                            >
                                CRM-система позволяет оптимально организовать
                                управление маркетингом компании: проводить
                                маркетинговые мероприятия, управлять ресурсами и
                                бюджетами на маркетинг, координировать
                                маркетинговые воздействия.
                            </p>
                        </div>

                        <div class="space-y-4">
                            <h3
                                class="text-2xl font-bold leading-tight text-gray-900 dark:text-white"
                            >
                                Управление продажами
                            </h3>
                            <p
                                class="text-lg font-normal text-gray-500 dark:text-gray-400"
                            >
                                Любой коммерческой организации важно
                                предоставлять продукты и услуги высокого
                                качества по конкурентным ценам, постоянно
                                усовершенствовать продуктовые линейки.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </template>
    </AuthenticatedLayout>
</template>
