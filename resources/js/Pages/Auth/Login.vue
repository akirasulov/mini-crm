<template>
    <Head title="Вход" />
    <GuestLayout>
        <div class="bg-white dark:bg-gray-900">
            <div class="flex h-screen justify-center">
                <div
                    class="hidden bg-cover lg:block lg:w-2/3"
                    style="
                        background-image: url(&quot;/assets/images/crm.jpg&quot;);
                    "
                >
                    <!-- <div
                        class="flex h-full items-center bg-gray-900 bg-opacity-40 px-20"
                    >
                        <div>
                            <h2
                                class="text-2xl font-bold text-white sm:text-3xl"
                            >
                                CRM
                            </h2>

                            <p class="mt-3 max-w-xl text-gray-300">
                                TEXT
                            </p>
                        </div>
                    </div> -->
                </div>

                <div
                    class="mx-auto flex w-full max-w-md items-center px-6 lg:w-2/6"
                >
                    <div class="flex-1">
                        <div class="text-center">
                            <div class="mx-auto flex justify-center">
                                <ApplicationLogo />
                            </div>

                            <p class="mt-3 text-gray-500 dark:text-gray-300">
                                Войдите в систему для доступа к своему аккаунту
                            </p>
                        </div>

                        <div class="mt-8">
                            <form @submit.prevent="submit">
                                <div>
                                    <InputLabel for="login" value="Логин" />

                                    <TextInput
                                        id="email"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.email"
                                        required
                                        placeholder="example@example.com"
                                        autofocus
                                        autocomplete="username"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.email"
                                    />
                                </div>

                                <div class="mt-6">
                                    <div class="mb-2 flex justify-between">
                                        <InputLabel
                                            for="password"
                                            value="Пароль"
                                        />

                                        <Link
                                            v-if="canResetPassword"
                                            :href="route('password.request')"
                                            class="text-sm text-gray-400 hover:text-blue-500 hover:underline focus:text-blue-500"
                                            >Забыли пароль?</Link
                                        >
                                    </div>
                                    <TextInput
                                        id="password"
                                        type="password"
                                        class="mt-1 block w-full"
                                        v-model="form.password"
                                        placeholder="Ваш Пароль"
                                        required
                                        autocomplete="password"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.password"
                                    />
                                </div>

                                <div class="mt-6">
                                    <button
                                        class="w-full transform rounded-lg bg-blue-500 px-4 py-2 tracking-wide text-white transition-colors duration-300 hover:bg-blue-400 focus:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50"
                                    >
                                        Вход
                                    </button>
                                </div>
                            </form>

                            <p class="mt-6 text-center text-sm text-gray-400">
                                Нет аккаунта?
                                <Link
                                    :href="route('register')"
                                    class="text-blue-500 hover:underline focus:underline focus:outline-none"
                                    >Создать аккаут</Link
                                >
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { useForm } from "@inertiajs/vue3";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<style lang="scss" scoped></style>
