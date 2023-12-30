<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { ArrowLongLeftIcon } from "@heroicons/vue/24/solid";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <GuestLayout>
        <Head title="Востановление пароля" />

        <section class="bg-white dark:bg-gray-900">
            <div class="absolute left-9 top-9">
                <Link
                    href="/"
                    class="mb-4 flex items-center justify-center gap-x-2 rounded-lg border bg-white px-5 py-2 text-sm text-gray-700 transition-colors duration-200 hover:bg-gray-100 sm:w-auto dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800"
                >
                    <ArrowLongLeftIcon class="size-6" />

                    <span>Назад</span>
                </Link>
            </div>
            <div
                class="container mx-auto flex min-h-screen flex-col items-center justify-center px-6"
            >
                <div class="mx-auto flex justify-center">
                    <ApplicationLogo />
                </div>
                <div
                    v-if="status"
                    class="mb-4 text-sm font-medium text-green-600 dark:text-green-400"
                >
                    {{ status }}
                </div>
                <div class="mx-auto mt-6 w-full max-w-md">
                    <form @submit.prevent="submit">
                        <InputLabel for="email" value="Email" />

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                        />

                        <InputError class="mt-2" :message="form.errors.email" />
                        <button
                            class="mt-4 w-full transform rounded-lg bg-blue-500 px-6 py-3 text-sm font-medium capitalize tracking-wide text-white transition-colors duration-300 hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50"
                        >
                            Сбросить пароль
                        </button>

                        <p
                            class="mt-6 text-xs text-gray-500 dark:text-gray-400"
                        >
                            Забыли пароль? Без проблем. Просто сообщите нам свой
                            адрес электронной почты адрес, и мы вышлем вам по
                            электронной почте ссылку для сброса пароля, которая
                            позволит вам выбрать новый.
                        </p>
                    </form>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>
