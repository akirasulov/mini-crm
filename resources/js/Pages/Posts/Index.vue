<template>
    <Head title="Обращения" />
    <AuthenticatedLayout>
        <div class="relative shadow-md sm:rounded-lg">
            <section class="h-full bg-white p-4 dark:bg-gray-900">
                <div
                    class="flex-column flex flex-wrap items-center justify-between space-y-4 md:flex-row md:space-y-0"
                >
                    <section class="flex space-x-3">
                        <div>
                            <label
                                for="countries_disabled"
                                class="block translate-y-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Удалённые :</label
                            >
                            <select
                                id="underline_select"
                                v-model="form.trashed"
                                class="peer block w-full appearance-none border-0 border-b-2 border-gray-200 bg-transparent px-0 py-2.5 text-sm text-gray-500 focus:border-gray-200 focus:outline-none focus:ring-0 dark:border-gray-700 dark:text-gray-400"
                            >
                                <option :value="null">Активные</option>
                                <option value="with">Все</option>
                                <option value="only">Удалённые</option>
                            </select>
                        </div>
                        <div>
                            <label
                                for="countries_disabled"
                                class="block translate-y-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Статус :</label
                            >
                            <select
                                id="underline_select"
                                v-model="form.status"
                                class="peer block w-full appearance-none border-0 border-b-2 border-gray-200 bg-transparent px-0 py-2.5 text-sm text-gray-500 focus:border-gray-200 focus:outline-none focus:ring-0 dark:border-gray-700 dark:text-gray-400"
                            >
                                <option :value="null">Все</option>
                                <option :value="STATUS_PROGRESS">
                                    Рассматривается
                                </option>
                                <option :value="STATUS_DONE">
                                    Рассмотрено
                                </option>
                            </select>
                        </div>
                    </section>

                    <label for="table-search" class="sr-only">Поиск</label>
                    <div class="relative">
                        <div
                            class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3"
                        >
                            <MagnifyingGlassIcon
                                class="h-4 w-4 text-gray-500 dark:text-gray-400"
                            />
                        </div>
                        <input
                            type="search"
                            v-model="form.search"
                            id="table-search-users"
                            class="block w-72 rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            placeholder="Поиск пользователей"
                        />
                    </div>
                </div>
            </section>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table
                    class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400"
                >
                    <thead
                        class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">Лиц. счет</th>
                            <th scope="col" class="px-6 py-3">ФИО</th>
                            <th scope="col" class="px-6 py-3">Статус</th>
                            <th scope="col" class="px-6 py-3">Название</th>
                            <th scope="col" class="px-6 py-3">Номер</th>
                            <th scope="col" class="px-6 py-3">Ответсвенный</th>
                            <th scope="col" class="px-6 py-3">Дата создания</th>
                            <th scope="col" class="px-6 py-3"></th>
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
                                {{ post.uuid }}
                            </th>
                            <td class="px-6 py-4">{{ post.fullname }}</td>
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
                            <td class="px-6 py-4">{{ post.title }}</td>
                            <td class="px-6 py-4">{{ post.msisdn }}</td>
                            <td class="px-6 py-4">{{ post.operator }}</td>
                            <td class="px-6 py-4">{{ post.created_at }}</td>
                            <td
                                class="flex items-center justify-center px-6 py-4"
                            >
                                <Link
                                    :href="route('posts.edit', post)"
                                    class="font-medium text-blue-600 hover:underline dark:text-blue-500"
                                >
                                    <ChevronRightIcon class="size-6" />
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <Pagination class="py-4" :links="posts.links" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import pickBy from "lodash/pickBy";
import { watch } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import debounce from "lodash/debounce";
import { MagnifyingGlassIcon, ChevronRightIcon } from "@heroicons/vue/24/solid";
const props = defineProps({ filters: Object, posts: Object });
import { usePermission } from "@/Composables/permissions";
const { checkpermission } = usePermission();
let form = useForm({
    search: props.filters.search,
    trashed: props.filters.trashed,
    status: props.filters.status,
});
const STATUS_PROGRESS = 1; // На реализации
const STATUS_DONE = 2; // Готов

watch(
    form,
    debounce(function (value) {
        router.get("/posts", pickBy(form), {
            preserveState: true,
            replace: true,
        });
    }, 150),
);
</script>
