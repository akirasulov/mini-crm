<script setup>
import { onMounted } from "vue";
import { initDropdowns } from "flowbite";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { ChevronRightIcon } from "@heroicons/vue/24/solid";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    roles: Object,
    permissions: Object,
});
onMounted(() => {
    initDropdowns();
});

const form = useForm({
    name: "",
    surname: "",
    email: "",
    login: "",
    password: "",
    roles: [],
    permissions: [],
});

const targetRole = (target) => {
    if (target.checked) {
        form.roles.push(target.value);
    } else {
        form.roles = form.roles.filter((item) => item !== target.value);
    }
};

const targePermission = (target) => {
    if (target.checked) {
        form.permissions.push(target.value);
    } else {
        form.permissions = form.permissions.filter(
            (item) => item !== target.value,
        );
    }
};

const submit = () => {
    form.post(route("users.store"), {
        preserveScroll: true,
        onSuccess: () =>
            form.reset("name", "surname", "password", "email", "login"),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset("name", "surname", "email", "login"),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <section class="bg-white dark:bg-gray-800">
            <div class="flex w-full max-w-3xl items-center">
                <div class="w-full">
                    <h1
                        class="text-2xl font-semibold capitalize tracking-wider text-gray-800 dark:text-white"
                    >
                        Создание пользователя
                    </h1>

                    <form
                        @submit.prevent="submit"
                        class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2"
                    >
                        <div>
                            <InputLabel for="name" value="Имя" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Имя"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </div>
                        <div>
                            <InputLabel for="surname" value="Фамилия" />

                            <TextInput
                                id="surname"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Фамилия"
                                v-model="form.surname"
                                required
                                autocomplete="surname"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.surname"
                            />
                        </div>
                        <div>
                            <InputLabel for="login" value="Логин" />

                            <TextInput
                                id="login"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.login"
                                placeholder="Логин"
                                required
                                autocomplete="login"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.login"
                            />
                        </div>

                        <div>
                            <InputLabel for="email" value="Email" />

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                placeholder="Email"
                                required
                                autocomplete="email"
                            />

                            <InputError
                                :message="form.errors.email"
                                class="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel for="password" value="Пароль" />

                            <TextInput
                                id="password"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password"
                                placeholder="Пароль"
                                required
                                autocomplete="password"
                            />

                            <InputError
                                :message="form.errors.password"
                                class="mt-2"
                            />
                        </div>

                        <section class="flex items-end space-x-4">
                            <div>
                                <button
                                    id="roleDropdownButton"
                                    data-dropdown-toggle="roleDropdown"
                                    class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                    type="button"
                                >
                                    Роли
                                    <svg
                                        class="ms-3 h-2.5 w-2.5"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 10 6"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m1 1 4 4 4-4"
                                        />
                                    </svg>
                                </button>

                                <!-- Dropdown menu -->
                                <div
                                    id="roleDropdown"
                                    class="z-10 hidden w-48 divide-y divide-gray-100 rounded-lg bg-white shadow dark:divide-gray-600 dark:bg-gray-700"
                                >
                                    <ul
                                        class="space-y-3 p-3 text-sm text-gray-700 dark:text-gray-200"
                                        aria-labelledby="roleDropdownButton"
                                    >
                                        <li
                                            v-for="role in roles"
                                            :key="role.id"
                                        >
                                            <div class="flex items-center">
                                                <input
                                                    type="checkbox"
                                                    :value="role.name"
                                                    @change="
                                                        targetRole(
                                                            $event.target,
                                                        )
                                                    "
                                                    class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:ring-offset-gray-700 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-700"
                                                />
                                                <label
                                                    for="checkbox-item-1"
                                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    >{{ role.name }}</label
                                                >
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <button
                                    id="permissionDropdownButton"
                                    data-dropdown-toggle="permissionDropdown"
                                    class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                    type="button"
                                >
                                    Разрешения
                                    <svg
                                        class="ms-3 h-2.5 w-2.5"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 10 6"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m1 1 4 4 4-4"
                                        />
                                    </svg>
                                </button>

                                <!-- Dropdown menu -->
                                <div
                                    id="permissionDropdown"
                                    class="z-10 hidden w-48 divide-y divide-gray-100 rounded-lg bg-white shadow dark:divide-gray-600 dark:bg-gray-700"
                                >
                                    <ul
                                        class="space-y-3 p-3 text-sm text-gray-700 dark:text-gray-200"
                                        aria-labelledby="permissionDropdownButton"
                                    >
                                        <li
                                            v-for="permission in permissions"
                                            :key="permission.id"
                                        >
                                            <div class="flex items-center">
                                                <input
                                                    type="checkbox"
                                                    :value="permission.name"
                                                    @change="
                                                        targePermission(
                                                            $event.target,
                                                        )
                                                    "
                                                    class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:ring-offset-gray-700 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-700"
                                                />
                                                <label
                                                    for="checkbox-item-1"
                                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    >{{
                                                        permission.name
                                                    }}</label
                                                >
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </section>

                        <button
                            class="flex w-full transform items-center justify-between rounded-lg bg-blue-500 px-6 py-2 text-sm capitalize tracking-wide text-white transition-colors duration-300 hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50"
                        >
                            <span>Создать</span>
                            <ChevronRightIcon
                                class="h-5 w-5 rtl:-scale-x-100"
                            />
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
