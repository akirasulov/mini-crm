<template>
    <AuthenticatedLayout>
        <div
            class="overflow-x-aut relative h-screen p-20 shadow-md sm:rounded-lg"
        >
            <section class="bg-white p-4 dark:bg-gray-900">
                <div class="flex justify-end p-2">
                    <Link type="button">
                        <UserPlusIcon
                            class="size-7 text-purple-600 dark:text-green-400"
                        />
                    </Link>
                </div>
                <div
                    class="flex-column flex flex-wrap items-center justify-between space-y-4 md:flex-row md:space-y-0"
                >
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
                            <option :value="null">По умолчанию</option>
                            <option value="with">С удалёнными</option>
                            <option value="only">Только удалённые</option>
                        </select>
                    </div>
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div
                            class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3"
                        >
                            <MagnifyingGlassIcon
                                class="h-4 w-4 text-gray-500 dark:text-gray-400"
                            />
                        </div>
                        <input
                            type="text"
                            v-model="form.search"
                            id="table-search-users"
                            class="block w-80 rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            placeholder="Поиск пользователей"
                        />
                    </div>
                </div>
            </section>
            <!-- <table
                class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400"
            >
                <thead
                    class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">Имя</th>
                        <th scope="col" class="px-6 py-3">Логин</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(user, index) in users.data"
                        :key="user.id"
                        class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600"
                    >
                        <td class="px-6 py-4">{{ user.fullname }}</td>
                        <td class="px-6 py-4">{{ user.login }}</td>
                        <td class="px-6 py-4">{{ user.email }}</td>
                        <td class="flex items-center space-x-3 px-6 py-4">
                            <Link
                                :data-tooltip-target="`tooltip-edit-${index}`"
                                :href="route('users.edit', user)"
                                class="font-medium text-blue-600 hover:underline dark:text-blue-500"
                            >
                                <PencilIcon class="size-4" />
                            </Link>
                            <div
                                :id="`tooltip-edit-${index}`"
                                role="tooltip"
                                class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700"
                            >
                                Изменить
                                <div
                                    class="tooltip-arrow"
                                    data-popper-arrow
                                ></div>
                            </div>
                            <button
                                @click.prevent="deleteUser(user.id)"
                                :data-tooltip-target="`tooltip-delete-${index}`"
                                type="button"
                            >
                                <UserMinusIcon class="size-4 text-red-600" />
                            </button>
                            <div
                                :id="`tooltip-delete-${index}`"
                                role="tooltip"
                                class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700"
                            >
                                Удалить
                                <div
                                    class="tooltip-arrow"
                                    data-popper-arrow
                                ></div>
                            </div>
                        </td>
                    </tr>
                </tbody>

              
            </table> -->

            <ul role="list" class="divide-y divide-gray-100">
                <li v-for="(user, index) in users.data" :key="user.id">
                    <Link
                        class="flex justify-between gap-x-6 px-2 py-5 hover:bg-gray-600"
                        :href="route('users.edit', user)"
                    >
                        <div class="flex min-w-0 gap-x-4">
                            <img
                                class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt=""
                            />
                            <div class="min-w-0 flex-auto">
                                <p
                                    class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-200"
                                >
                                    {{ user.fullname }}
                                </p>
                                <p
                                    class="mt-1 truncate text-xs leading-5 text-gray-500"
                                >
                                    {{ user.email }}
                                </p>
                            </div>
                        </div>
                        <div
                            class="hidden shrink-0 sm:flex sm:flex-col sm:items-end"
                        >
                            <p
                                class="text-sm leading-6 text-gray-900 dark:text-gray-200"
                            >
                                {{ user.login }}
                            </p>
                            <p
                                v-if="user.id != $page.props.auth.user.id"
                                class="mt-1 text-xs leading-5 text-gray-500"
                            >
                                Заходил (а)
                                <time :datetime="user.last_seen">{{
                                    user.last_seen
                                }}</time>
                            </p>

                            <div
                                v-else
                                class="mt-1 flex items-center gap-x-1.5"
                            >
                                <div
                                    class="flex-none rounded-full bg-emerald-500/20 p-1"
                                >
                                    <div
                                        class="h-1.5 w-1.5 rounded-full bg-emerald-500"
                                    />
                                </div>
                                <p class="text-xs leading-5 text-gray-500">
                                    Онлайн
                                </p>
                            </div>
                        </div>
                    </Link>
                </li>
            </ul>
            <Pagination :links="users.links" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";
import { watch } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import debounce from "lodash/debounce";
import {
    MagnifyingGlassIcon,
    PencilIcon,
    UserMinusIcon,
    UserPlusIcon,
} from "@heroicons/vue/24/solid";
const props = defineProps({ filters: Object, users: Object });
let form = useForm({
    search: props.filters.search,
    trashed: props.filters.trashed,
});

watch(
    form,
    debounce(function (value) {
        router.get("/users", pickBy(form), {
            preserveState: true,
            replace: true,
        });
    }, 150),
);
const reset = () => {
    form = mapValues(form, () => null);
};

const deleteUser = (id) => {
    router.delete(route("users.destroy", { id: id }), {
        preserveScroll: true,
    });
};
</script>
