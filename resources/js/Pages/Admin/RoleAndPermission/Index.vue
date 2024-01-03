<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import { MinusIcon, PlusIcon } from "@heroicons/vue/24/solid";
import { onMounted } from "vue";
import { initTooltips } from "flowbite";
defineProps({
    roles: Object,
    permissions: Object,
});

const form = useForm({
    role: "",
    permission: "",
});

const submit = () => {
    form.post(
        route("permissions.assign", {
            role: form.role,
            permission: form.permission,
        }),
        {
            onFinish: () => form.reset("name"),
        },
    );
};

const remove = (roleId, permissionId) => {
    router.post(
        route("permissions.remove", {
            role: roleId,
            permission: permissionId,
        }),
    );
};
const destroyRole = (roleId) => {
    router.post(
        route("roles.destroy", {
            role: roleId,
        }),
    );
};
onMounted(() => {
    initTooltips();
});
</script>

<template>
    <Head title="Синхронизация" />

    <AuthenticatedLayout>
        <div class="mx-auto max-w-7xl">
            <div
                class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
            >
                <div class="mb-3 flex justify-end">
                    <Link
                        :href="route('permissions.create')"
                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 dark:border-gray-500 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800"
                    >
                        Создать
                        <PlusIcon class="ml-1 size-5" />
                    </Link>
                </div>
                <form
                    @submit.prevent="submit"
                    class="rounded-lg border border-gray-100 bg-gray-50 p-5 dark:border-gray-700 dark:bg-gray-800"
                >
                    <ol class="mt-3">
                        <li>
                            <label
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                >Выберите роль</label
                            >
                            <select
                                v-model="form.role"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            >
                                <option
                                    v-for="role in roles"
                                    :key="role.id"
                                    :value="role.id"
                                >
                                    {{ role.name }}
                                </option>
                            </select>
                        </li>
                        <li class="mt-4">
                            <label
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                >Выберите разрешение</label
                            >
                            <select
                                v-model="form.permission"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            >
                                <option
                                    v-for="permission in permissions"
                                    :key="permission.id"
                                    :value="permission.id"
                                >
                                    {{ permission.name }}
                                </option>
                            </select>
                        </li>
                    </ol>
                    <PrimaryButton
                        class="mt-4"
                        :loading="form.processing"
                        :disabled="form.processing"
                        >Сохранить</PrimaryButton
                    >
                </form>
            </div>
            <div
                class="grid grid-cols-2 justify-items-center gap-10 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4"
            >
                <ol
                    v-for="(role, index) in roles"
                    :key="role.id"
                    class="relative border-s border-gray-200 dark:border-gray-700"
                >
                    <h3
                        class="m-4 text-lg font-semibold text-gray-900 dark:text-white"
                    >
                        {{ role.name }}
                        <button
                            :data-tooltip-target="`tooltip-parent-${index}`"
                            type="button"
                            @click.prevent="destroyRole(role.id)"
                        >
                            <MinusIcon
                                class="h-3 w-5 rounded bg-purple-600 text-red-200"
                            />
                        </button>

                        <div
                            :id="`tooltip-parent-${index}`"
                            role="tooltip"
                            class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700"
                        >
                            Удалить все синхронизации
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </h3>

                    <li
                        v-for="permission in role.permissions"
                        :key="permission.id"
                        class="mb-10 ms-4"
                    >
                        <div
                            class="absolute -start-1.5 mt-1.5 h-3 w-3 rounded-full border border-white bg-gray-200 dark:border-gray-900 dark:bg-gray-700"
                        ></div>
                        <div class="flex items-center space-x-3">
                            <time
                                class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"
                                >{{ permission.name }}</time
                            >

                            <button
                                :data-tooltip-target="`tooltip-child-${index}-${permission.id}`"
                                type="button"
                                @click.prevent="remove(role.id, permission.id)"
                            >
                                <MinusIcon
                                    class="h-3 w-5 rounded bg-red-600 text-red-200"
                                />
                            </button>
                            <div
                                :id="`tooltip-child-${index}-${permission.id}`"
                                role="tooltip"
                                class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700"
                            >
                                Удалить синхронизацию
                                <div
                                    class="tooltip-arrow"
                                    data-popper-arrow
                                ></div>
                            </div>
                        </div>
                    </li>
                </ol>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
