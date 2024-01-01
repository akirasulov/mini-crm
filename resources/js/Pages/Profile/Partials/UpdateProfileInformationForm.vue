<script setup>
import { UserCircleIcon } from "@heroicons/vue/24/solid";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const photoInput = ref(null);
const photoPreview = ref(false);
const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);

    router.post(
        route("users.avatar", user.id),
        {
            profile_photo_path: photoInput.value.files[0],
        },
        { preserveScroll: true },
    );
};
const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    surname: user.surname,
    login: user.login,
    email: user.email,
    profile_photo_path: user.profile_photo_path,
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Информация пользователя
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Обновите информацию профиля учетной записи.
            </p>
        </header>

        <div class="my-6">
            <InputLabel for="name" value="Фото" />

            <div class="mt-2 flex items-center gap-x-3">
                <div v-if="!photoPreview">
                    <img
                        v-if="form.profile_photo_path"
                        class="h-12 w-12 rounded-full"
                        :src="form.profile_photo_path"
                        :alt="form.fullname"
                    />
                    <UserCircleIcon
                        v-else
                        class="h-12 w-12 text-gray-300"
                        aria-hidden="true"
                    />
                </div>
                <div v-show="photoPreview" class="mt-2">
                    <span
                        class="block h-10 w-10 rounded-full bg-cover bg-center bg-no-repeat"
                        :style="
                            'background-image: url(\'' + photoPreview + '\');'
                        "
                    />
                </div>

                <label
                    for="file-upload"
                    class="cursor-pointer rounded-md bg-gray-900 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm transition-colors duration-300 hover:bg-gray-700 dark:bg-white dark:text-gray-900 hover:dark:bg-gray-200"
                >
                    <span>Загрузить</span>
                    <input
                        id="file-upload"
                        name="file-upload"
                        ref="photoInput"
                        type="file"
                        class="sr-only"
                        @change="updatePhotoPreview"
                    />
                </label>
            </div>
        </div>

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="space-y-6"
        >
            <div>
                <InputLabel for="name" value="Имя" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="surname" value="Фамилия" />

                <TextInput
                    id="surname"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.surname"
                    required
                    autofocus
                    autocomplete="surname"
                />

                <InputError class="mt-2" :message="form.errors.surname" />
            </div>

            <div>
                <InputLabel for="login" value="Логин" />

                <TextInput
                    id="login"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.login"
                    required
                    autocomplete="login"
                />

                <InputError class="mt-2" :message="form.errors.login" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800 dark:text-gray-200">
                    Ваш адрес электронной почты не подтвержден.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                    >
                        Нажмите здесь, чтобы повторно отправить письмо с
                        подтверждением.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600 dark:text-green-400"
                >
                    На ваш адрес электронной почты была отправлена новая ссылка
                    для подтверждения.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing"
                    >Сохранить</PrimaryButton
                >

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
