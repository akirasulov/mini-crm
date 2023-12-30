<template>
    <AuthenticatedLayout>
        <form>
            <div class="space-y-12">
                <h2
                    class="text-base font-semibold leading-7 text-gray-900 dark:text-white"
                >
                    {{ user.fullname }}
                </h2>

                <div class="border-b border-gray-900/10 pb-12">
                    <h2
                        class="text-base font-semibold leading-7 text-gray-900 dark:text-white"
                    >
                        Персональная данные
                    </h2>

                    <div
                        class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                    >
                        <div class="sm:col-span-3">
                            <InputLabel for="name" value="Имя" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                autofocus
                            />

                            <InputError
                                :message="form.errors.name"
                                class="mt-2"
                            />
                        </div>

                        <div class="sm:col-span-3">
                            <InputLabel for="surname" value="Фамилия" />

                            <TextInput
                                id="surname"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.surname"
                            />

                            <InputError
                                :message="form.errors.surname"
                                class="mt-2"
                            />
                        </div>

                        <div class="sm:col-span-3">
                            <InputLabel for="login" value="Логин" />

                            <TextInput
                                id="login"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.login"
                            />

                            <InputError
                                :message="form.errors.login"
                                class="mt-2"
                            />
                        </div>
                        <div class="sm:col-span-3">
                            <InputLabel for="email" value="Email" />

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                            />

                            <InputError
                                :message="form.errors.email"
                                class="mt-2"
                            />
                        </div>

                        <div class="sm:col-span-3">
                            <InputLabel for="password" value="Пароль" />

                            <TextInput
                                id="password"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password"
                            />

                            <InputError
                                :message="form.errors.email"
                                class="mt-2"
                            />
                        </div>

                        <div class="col-span-full">
                            <div
                                id="accordion-flush"
                                data-accordion="collapse"
                                data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
                                data-inactive-classes="text-gray-500 dark:text-gray-400"
                            >
                                <h2 id="accordion-flush-heading-1">
                                    <button
                                        type="button"
                                        class="flex w-full items-center justify-between gap-3 border-b border-gray-200 py-5 font-medium text-gray-500 rtl:text-right dark:border-gray-700 dark:text-gray-400"
                                        data-accordion-target="#accordion-flush-body-1"
                                        aria-expanded="true"
                                        aria-controls="accordion-flush-body-1"
                                    >
                                        <div class="flex items-center">
                                            <KeyIcon class="ml-2 mr-4 size-4" />
                                            Роли
                                        </div>

                                        <svg
                                            data-accordion-icon
                                            class="h-3 w-3 shrink-0 rotate-180"
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
                                                d="M9 5 5 1 1 5"
                                            />
                                        </svg>
                                    </button>
                                </h2>
                                <div
                                    id="accordion-flush-body-1"
                                    class="hidden"
                                    aria-labelledby="accordion-flush-heading-1"
                                >
                                    <div
                                        class="flex flex-wrap space-x-6 border-b border-gray-200 py-5 dark:border-gray-700"
                                    >
                                        <div
                                            v-for="role in roles"
                                            :key="role.id"
                                        >
                                            <div class="relative flex gap-x-3">
                                                <div
                                                    class="flex h-6 items-center"
                                                >
                                                    <input
                                                        @change="
                                                            changeRole(
                                                                $event.target,
                                                            )
                                                        "
                                                        :value="role.name"
                                                        :checked="
                                                            user.roles.some(
                                                                (r) =>
                                                                    r.id ===
                                                                    role.id,
                                                            )
                                                        "
                                                        type="checkbox"
                                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                                    />
                                                </div>
                                                <div class="text-sm leading-6">
                                                    <label
                                                        for="comments"
                                                        class="font-medium text-gray-900 dark:text-gray-200"
                                                        >{{ role.name }}</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h2 id="accordion-flush-heading-2">
                                    <button
                                        type="button"
                                        class="flex w-full items-center justify-between gap-3 border-b border-gray-200 py-5 font-medium text-gray-500 rtl:text-right dark:border-gray-700 dark:text-gray-400"
                                        data-accordion-target="#accordion-flush-body-2"
                                        aria-expanded="false"
                                        aria-controls="accordion-flush-body-2"
                                    >
                                        <div class="flex items-center">
                                            <KeyIcon class="ml-2 mr-4 size-4" />
                                            Разрешения
                                        </div>
                                        <svg
                                            data-accordion-icon
                                            class="h-3 w-3 shrink-0 rotate-180"
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
                                                d="M9 5 5 1 1 5"
                                            />
                                        </svg>
                                    </button>
                                </h2>
                                <div
                                    id="accordion-flush-body-2"
                                    class="hidden"
                                    aria-labelledby="accordion-flush-heading-2"
                                >
                                    <div
                                        class="flex flex-wrap space-x-6 border-b border-gray-200 py-5 dark:border-gray-700"
                                    >
                                        <div
                                            v-for="permission in permissions"
                                            :key="permission.id"
                                        >
                                            <div class="relative flex gap-x-3">
                                                <div
                                                    class="flex h-6 items-center"
                                                >
                                                    <input
                                                        @change="
                                                            changePermission(
                                                                $event.target,
                                                            )
                                                        "
                                                        :value="permission.name"
                                                        :checked="
                                                            user.permissions.some(
                                                                (p) =>
                                                                    p.id ===
                                                                    permission.id,
                                                            )
                                                        "
                                                        type="checkbox"
                                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                                    />
                                                </div>
                                                <div class="text-sm leading-6">
                                                    <label
                                                        for="comments"
                                                        class="font-medium text-gray-900 dark:text-gray-200"
                                                        >{{
                                                            permission.name
                                                        }}</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <Link
                    href="/"
                    class="text-sm font-semibold leading-6 text-gray-900 dark:text-white"
                >
                    Назад
                </Link>
                <PrimaryButton :disabled="form.processing"
                    >Сохранить</PrimaryButton
                >
            </div>
        </form>
    </AuthenticatedLayout>
</template>

<script setup>
import { KeyIcon } from "@heroicons/vue/24/solid";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
const props = defineProps({
    user: Object,
    roles: Object,
    permissions: Object,
    flash: Object,
});

const form = useForm({
    name: props.user.name,
    surname: props.user.surname,
    login: props.user.login,
    email: props.user.email,
});
const changeRole = (target) => {
    router.post(
        route("users.role", { preserveScroll: true, id: props.user.id }),
        {
            role_name: target.value,
            checked: target.checked,
        },
    );
};

const changePermission = (target) => {
    router.post(
        route("users.permission", { preserveScroll: true, id: props.user.id }),
        {
            permission_name: target.value,
            checked: target.checked,
        },
    );
};
</script>
