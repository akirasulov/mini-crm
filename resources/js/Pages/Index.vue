<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePermission } from "@/Composables/permissions";
import { EyeIcon, DocumentPlusIcon } from "@heroicons/vue/24/solid";
import Pagination from "@/Components/Pagination.vue";
const { checkpermission } = usePermission();
defineProps({
    posts: Object,
});

const STATUS_PROGRESS = 1; // На реализации
const STATUS_DONE = 2; // Готов
</script>

<template>
    <Head title="Главная" />
    <AuthenticatedLayout>
        <template v-if="checkpermission.isClient">
            <section class="bg-gray-50 p-3 sm:p-5 dark:bg-gray-900">
                <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                    <div
                        class="relative overflow-hidden bg-white shadow-md sm:rounded-lg dark:bg-gray-800"
                    >
                        <div
                            v-if="checkpermission.canCreatePost"
                            class="flex justify-end p-2"
                        >
                            <Link
                                class="flex items-center rounded-md border border-purple-400 p-1 dark:border-green-400"
                                :href="route('posts.create')"
                            >
                                <DocumentPlusIcon
                                    class="size-7 text-purple-600 dark:text-green-400"
                                />
                                <span
                                    class="text-purple-600 dark:text-green-400"
                                    >Создать</span
                                >
                            </Link>
                        </div>
                        <div class="overflow-x-auto">
                            <table
                                class="w-full text-left text-sm text-gray-500 dark:text-gray-400"
                            >
                                <thead
                                    class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400"
                                >
                                    <tr>
                                        <th scope="col" class="px-6 py-3"></th>
                                        <th scope="col" class="px-6 py-3">
                                            Тема
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Статус
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            ФИО
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            Номер
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            Дата создания
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr
                                        v-for="post in posts.data"
                                        :key="post.id"
                                        class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600"
                                    >
                                        <th
                                            scope="row"
                                            class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white"
                                        >
                                            <button
                                                data-modal-target="crud-modal"
                                                data-modal-toggle="crud-modal"
                                                class="block rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                type="button"
                                            >
                                                <EyeIcon class="size-6" />
                                            </button>
                                            <!-- Modal -->

                                            <div
                                                id="crud-modal"
                                                tabindex="-1"
                                                aria-hidden="true"
                                                class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
                                            >
                                                <div
                                                    class="relative max-h-full w-full max-w-md p-4"
                                                >
                                                    <!-- Modal content -->
                                                    <div
                                                        class="relative rounded-lg bg-white shadow dark:bg-gray-700"
                                                    >
                                                        <!-- Modal header -->
                                                        <div
                                                            class="flex items-center justify-between rounded-t border-b p-4 md:p-5 dark:border-gray-600"
                                                        >
                                                            <h3
                                                                class="text-lg font-semibold text-gray-900 dark:text-white"
                                                            >
                                                                {{ post.title }}
                                                            </h3>
                                                            <button
                                                                type="button"
                                                                class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                                                                data-modal-toggle="crud-modal"
                                                            >
                                                                <svg
                                                                    class="h-3 w-3"
                                                                    aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    fill="none"
                                                                    viewBox="0 0 14 14"
                                                                >
                                                                    <path
                                                                        stroke="currentColor"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                                                    />
                                                                </svg>
                                                                <span
                                                                    class="sr-only"
                                                                    >Закрыть</span
                                                                >
                                                            </button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <form
                                                            class="p-4 md:p-5"
                                                        >
                                                            <div
                                                                class="mb-4 grid grid-cols-2 gap-4"
                                                            >
                                                                <div
                                                                    class="col-span-2"
                                                                >
                                                                    <label
                                                                        class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                                                        >ФИО</label
                                                                    >
                                                                    <p
                                                                        class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                                                    >
                                                                        {{
                                                                            post.fullname
                                                                        }}
                                                                    </p>
                                                                </div>
                                                                <div
                                                                    class="col-span-2"
                                                                >
                                                                    <label
                                                                        class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                                                        >Оператор</label
                                                                    >
                                                                    <p
                                                                        class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                                                    >
                                                                        {{
                                                                            post.operator
                                                                        }}
                                                                    </p>
                                                                </div>
                                                                <div
                                                                    class="col-span-2"
                                                                >
                                                                    <label
                                                                        class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                                                        >Лицевой
                                                                        счет</label
                                                                    >
                                                                    <p
                                                                        class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                                                    >
                                                                        {{
                                                                            post.uuid
                                                                        }}
                                                                    </p>
                                                                </div>
                                                                <div
                                                                    class="col-span-2"
                                                                >
                                                                    <label
                                                                        class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                                                        >Описание</label
                                                                    >
                                                                    <p
                                                                        class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                                                    >
                                                                        {{
                                                                            post.body
                                                                        }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal -->
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ post.title }}
                                        </td>

                                        <td
                                            class="px-6 py-4 text-white"
                                            :class="
                                                post.status == STATUS_PROGRESS
                                                    ? 'bg-yellow-400'
                                                    : 'bg-green-600'
                                            "
                                        >
                                            {{
                                                post.status == STATUS_PROGRESS
                                                    ? "Рассматривается"
                                                    : "Расмотренно"
                                            }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ post.fullname }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ post.msisdn }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ post.created_at }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <Pagination class="py-4" :links="posts.links" />
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
