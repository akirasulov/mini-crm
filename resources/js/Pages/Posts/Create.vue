<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextArea from "@/Components/TextArea.vue";
import { ChevronRightIcon } from "@heroicons/vue/24/solid";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    fullname: "",
    title: "",
    body: "",
    msisdn: "",
});

const submit = () => {
    form.post(route("posts.store"), {
        preserveScroll: true,
        onSuccess: () => form.reset("fullname", "title", "body", "msisdn"),
        // onError: () => "",
    });
};
</script>

<template>
    <Head title="Создание обращения" />
    <AuthenticatedLayout>
        <section class="bg-white dark:bg-gray-800">
            <div class="mx-auto flex items-center">
                <div class="w-full">
                    <h1
                        class="text-2xl font-semibold capitalize tracking-wider text-gray-800 dark:text-white"
                    >
                        Создание обращения
                    </h1>

                    <form
                        @submit.prevent="submit"
                        class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2"
                    >
                        <div class="space-y-3.5">
                            <div>
                                <InputLabel for="title" value="Заголовок" />

                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    placeholder="Фамилия"
                                    v-model="form.title"
                                    required
                                    autocomplete="title"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.title"
                                />
                            </div>
                            <div>
                                <InputLabel for="fullname" value="ФИО" />

                                <TextInput
                                    id="fullname"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.fullname"
                                    placeholder="ФИО"
                                    required
                                    autocomplete="fullname"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.fullname"
                                />
                            </div>
                            <div>
                                <InputLabel
                                    for="phone"
                                    value="Номер телефона"
                                />

                                <TextInput
                                    id="phone"
                                    type="tel"
                                    class="mt-1 block w-full"
                                    placeholder="Номер телефона"
                                    v-model="form.msisdn"
                                    required
                                    autofocus
                                    autocomplete="phone"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.msisdn"
                                />
                            </div>
                        </div>
                        <div>
                            <InputLabel for="body" value="Описание" />
                            <TextArea
                                class="mt-1 block w-full"
                                v-model="form.body"
                                rows="8"
                                required
                                placeholder="Описание заявки"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.body"
                            />
                        </div>

                        <button
                            :disabled="form.processing"
                            class="flex w-full transform items-center justify-between rounded-lg bg-blue-500 px-6 py-2 text-sm capitalize tracking-wide text-white transition-colors duration-300 hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50"
                        >
                            <div
                                v-if="form.processing"
                                class="btn-spinner mr-2"
                            />
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
