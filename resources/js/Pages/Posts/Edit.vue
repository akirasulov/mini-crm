<template>
    <Head :title="post.title" />
    <AuthenticatedLayout>
        <form @submit.prevent="submit" class="bg-white dark:bg-gray-800">
            <div class="px-4 py-8 lg:py-16">
                <TrashedMessage
                    v-if="post.deleted_at && checkpermission.isAdmin"
                    class="mt-6"
                    @restore="restore"
                    >Данныая запись была удалёна.</TrashedMessage
                >
                <template v-if="checkpermission.canUpdatePostStatus">
                    <InputLabel for="status" value="Статус" />
                    <select
                        @change="statusTarget($event.target)"
                        class="my-2 inline-block w-44 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                    >
                        <option disabled selected class="bg-blue-800">
                            {{ currentStatus }}
                        </option>
                        <option value="1">Рассматривается</option>
                        <option value="2">Рассмотрено</option>
                    </select>
                </template>
                <h2
                    v-else
                    class="dark:text-hite mb-4 inline-block rounded-2xl p-3 text-xl font-bold text-white"
                    :class="
                        form.status == STATUS_DONE
                            ? 'bg-green-600'
                            : 'bg-yellow-400'
                    "
                >
                    {{ currentStatus }}
                </h2>
                <div class="grid gap-4 sm:grid-cols-3 sm:gap-6">
                    <div class="sm:col-span-3">
                        <InputLabel for="title" value="Заголовок" />

                        <TextInput
                            id="title"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.title"
                        />

                        <InputError :message="form.errors.title" class="mt-2" />
                    </div>
                    <div class="w-full">
                        <InputLabel for="operator" value="Ответственный" />
                        <template v-if="checkpermission.canChangeResponsible">
                            <VueMultiselect
                                class="mt-2"
                                v-model="selectedOperator"
                                @update:model-value="onSelectedOperator"
                                :options="operators"
                                :close-on-select="true"
                                :clear-on-select="false"
                                placeholder="Выберите оператора"
                                selectLabel="Выбрать оператора"
                                selectedLabel="Выбранный оператор"
                                deselectLabel="Убрать"
                                label="fullname"
                                track-by="fullname"
                            />
                        </template>
                        <template v-else>
                            <TextInput
                                id="operator"
                                type="text"
                                class="mt-1 block w-full"
                                disabled
                                v-model="form.operator.fullname"
                            />

                            <InputError
                                :message="form.errors.fullname"
                                class="mt-2"
                            />
                        </template>
                    </div>
                    <div class="w-full">
                        <InputLabel for="fullname" value="ФИО" />

                        <TextInput
                            id="fullname"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.fullname"
                        />

                        <InputError
                            :message="form.errors.fullname"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <InputLabel for="msisdn" value="Номер" />

                        <TextInput
                            id="msisdn"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.msisdn"
                        />

                        <InputError
                            :message="form.errors.msisdn"
                            class="mt-2"
                        />
                    </div>

                    <div class="sm:col-span-3">
                        <div class="sm:col-span-3">
                            <InputLabel for="body" value="Описание" />

                            <TextArea
                                class="mt-1 block w-full"
                                v-model="form.body"
                            />

                            <InputError
                                :message="form.errors.body"
                                class="mt-2"
                            />
                        </div>
                    </div>
                </div>

                <PrimaryButton
                    class="mt-4"
                    :disabled="form.processing"
                    :loading="form.processing"
                    >Сохранить</PrimaryButton
                >
                <DangerButton
                    class="ms-3"
                    :class="{
                        'opacity-25': form.processing,
                    }"
                    :disabled="form.processing"
                    :loading="form.processing"
                    type="button"
                    @click="destroy"
                >
                    Удалить запись
                </DangerButton>
            </div>
        </form>

        <form @submit.prevent="submitComment">
            <section
                class="mb-4 rounded-xl bg-white py-8 antialiased lg:py-16 dark:bg-gray-900"
            >
                <div class="mx-auto px-4">
                    <div class="mb-6 flex items-center justify-between">
                        <h2
                            class="text-lg font-bold text-gray-900 lg:text-2xl dark:text-white"
                        >
                            Комментарии
                        </h2>
                    </div>
                    <template v-if="checkpermission.canLeaveComment">
                        <div class="mb-6">
                            <div class="mb-4">
                                <label for="comment" class="sr-only"
                                    >Ваш комментарий</label
                                >

                                <TextArea
                                    class="block w-full"
                                    v-model="commentForm.body"
                                    placeholder="Ваш комментарий"
                                />
                            </div>
                            <PrimaryButton
                                class="mt-2"
                                :loading="commentForm.processing"
                                :disabled="commentForm.processing"
                                >Отправить</PrimaryButton
                            >
                        </div>
                    </template>
                    <article
                        v-for="comment in post.comments"
                        :key="comment.id"
                        class="rounded-lg bg-white p-6 text-base dark:bg-gray-900"
                    >
                        <footer class="mb-2 flex items-center justify-between">
                            <div class="flex items-center">
                                <p
                                    class="mr-3 inline-flex items-center text-sm font-semibold text-gray-900 dark:text-white"
                                >
                                    <img
                                        v-if="comment.user.profile_photo_path"
                                        class="mr-2 h-6 w-6 rounded-full"
                                        :src="comment.user.profile_photo_path"
                                        :alt="comment.user.email"
                                    />
                                    <UserCircleIcon
                                        v-else
                                        class="mr-2 size-9 rounded-full text-gray-300"
                                        aria-hidden="true"
                                    />
                                    {{ comment.user.fullname }}
                                </p>
                                <p
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >
                                    <time
                                        pubdate
                                        :datetime="comment.created_at"
                                        :title="comment.created_at"
                                        >{{ comment.created_at }}</time
                                    >
                                </p>
                            </div>
                        </footer>
                        <p class="text-gray-500 dark:text-gray-400">
                            {{ comment.body }}
                        </p>
                    </article>
                </div>
            </section>
        </form>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import TrashedMessage from "@/Shared/TrashedMessage.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import VueMultiselect from "vue-multiselect";
import { computed, ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import { UserCircleIcon } from "@heroicons/vue/24/solid";
import { usePermission } from "@/Composables/permissions";
const { checkpermission } = usePermission();
const props = defineProps({
    post: Object,
    operators: Object,
});

const STATUS_PROGRESS = 1; // На реализации
const STATUS_DONE = 2; // Готов
const form = useForm(props.post);
let selectedOperator = ref(form.operator);
const currentStatus = computed(() =>
    form.status == STATUS_PROGRESS ? "Рассматривается" : "Рассмотрено",
);
const onSelectedOperator = (operator) => {
    form.operator_id = operator.id;
};
const statusTarget = (target) => {
    form.status = target.value;
};
const commentForm = useForm({
    body: "",
});
const submit = () => {
    form.patch(route("posts.update", props.post), {
        preserveScroll: true,
    });
};
const restore = () => {
    if (confirm("Вы действительно хотите восстановить запись?")) {
        router.put(route("posts.restore", props.post));
    }
};
const destroy = () => {
    if (confirm("Вы действительно хотите удалить запись?")) {
        router.delete(
            route("posts.destroy", props.post),
            {},
            { preserveScroll: true },
        );
    }
};
const submitComment = () => {
    commentForm.post(route("comments.store", props.post), {
        preserveScroll: true,
        onSuccess: () => commentForm.reset("body"),
    });
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
