<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { ArrowLongLeftIcon } from "@heroicons/vue/24/solid";
const form = useForm({
    name: "",
    surname: "",
    email: "",
    login: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Регистрация" />

        <section class="bg-white dark:bg-gray-900">
            <div class="flex min-h-screen justify-center">
                <div
                    class="hidden bg-cover lg:block lg:w-2/5"
                    style="
                        background-image: url(&quot;/assets/images/9104455.jpg&quot;);
                    "
                ></div>

                <div
                    class="mx-auto flex w-full max-w-3xl items-center p-8 lg:w-3/5 lg:px-12"
                >
                    <div class="w-full">
                        <Link
                            href="/"
                            class="mb- 4 flex w-1/2 items-center justify-center gap-x-2 rounded-lg border bg-white px-5 py-2 text-sm text-gray-700 transition-colors duration-200 hover:bg-gray-100 sm:w-auto xl:w-full dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800"
                        >
                            <ArrowLongLeftIcon class="size-6" />

                            <span>Назад</span>
                        </Link>
                        <h1
                            class="mt-12 text-2xl font-semibold capitalize tracking-wider text-gray-800 dark:text-white"
                        >
                            Регистрация
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
                                    :message="form.errors.lgon"
                                />
                            </div>

                            <div>
                                <InputLabel for="email" value="Email" />

                                <TextInput
                                    id="login"
                                    type="email"
                                    class="mt-1 block w-full"
                                    placeholder="Email"
                                    v-model="form.email"
                                    required
                                    autocomplete="email"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.email"
                                />
                            </div>

                            <div>
                                <InputLabel for="password" value="Пароль" />

                                <TextInput
                                    id="login"
                                    type="password"
                                    v-model="form.password"
                                    class="mt-1 block w-full"
                                    placeholder="Пароль"
                                    required
                                    autocomplete="password"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.password"
                                />
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
                                    v-model="form.password_confirmation"
                                    placeholder="Подтверждение пароля"
                                    required
                                    autocomplete="confirm_password"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.password_confirmation"
                                />
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
            </div>
        </section>
    </GuestLayout>
</template>
