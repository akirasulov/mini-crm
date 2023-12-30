<script setup>
import { onMounted } from "vue";
import { initDropdowns } from "flowbite";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
onMounted(() => {
    initDropdowns();
});
</script>

<template>
    <AuthenticatedLayout>
        <section class="bg-white px-8 dark:bg-gray-900">
            <div class="flex h-lvh w-full max-w-3xl items-center">
                <div class="w-full">
                    <h1
                        class="text-2xl font-semibold capitalize tracking-wider text-gray-800 dark:text-white"
                    >
                        Создание пользователя
                    </h1>

                    <div class="mt-6">
                        <h1 class="text-gray-500 dark:text-gray-300">
                            Выберите роль
                        </h1>

                        <div class="mt-3 md:-mx-2 md:flex md:items-center">
                            <button
                                class="flex w-full justify-center rounded-lg bg-blue-500 px-6 py-3 text-white focus:outline-none md:mx-2 md:w-auto"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    />
                                </svg>

                                <span class="mx-2"> client </span>
                            </button>

                            <button
                                class="mt-4 flex w-full justify-center rounded-lg border border-blue-500 px-6 py-3 text-blue-500 focus:outline-none md:mx-2 md:mt-0 md:w-auto dark:border-blue-400 dark:text-blue-400"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>

                                <span class="mx-2"> worker </span>
                            </button>
                        </div>
                    </div>

                    <form class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <InputLabel for="name" value="Имя" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Имя"
                                required
                                autofocus
                                autocomplete="name"
                            />

                            <InputError class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="surname" value="Фамилия" />

                            <TextInput
                                id="surname"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Фамилия"
                                required
                                autocomplete="surname"
                            />

                            <InputError class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="login" value="Логин" />

                            <TextInput
                                id="login"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Логин"
                                required
                                autocomplete="login"
                            />

                            <InputError class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="email" value="Email" />

                            <TextInput
                                id="login"
                                type="email"
                                class="mt-1 block w-full"
                                placeholder="Email"
                                required
                                autocomplete="email"
                            />

                            <InputError class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="password" value="Пароль" />

                            <TextInput
                                id="login"
                                type="password"
                                class="mt-1 block w-full"
                                placeholder="Пароль"
                                required
                                autocomplete="password"
                            />

                            <InputError class="mt-2" />
                        </div>

                        <div>
                            <InputLabel
                                for="confirm_password"
                                value="Подтверждение пароля"
                            />

                            <TextInput
                                id="login"
                                type="password"
                                class="mt-1 block w-full"
                                placeholder="Подтверждение пароля"
                                required
                                autocomplete="confirm_password"
                            />

                            <InputError class="mt-2" />
                        </div>

                        <button
                            class="flex w-full transform items-center justify-between rounded-lg bg-blue-500 px-6 py-3 text-sm capitalize tracking-wide text-white transition-colors duration-300 hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50"
                        >
                            <span>Создать</span>

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 rtl:-scale-x-100"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
