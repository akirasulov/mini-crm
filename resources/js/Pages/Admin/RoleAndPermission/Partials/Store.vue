<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },

    route: {
        type: String,
        required: true,
    },
});
const form = useForm({
    name: "",
});

const submit = () => {
    form.post(route(props.route), {
        onFinish: () => form.reset("name"),
    });
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Создать {{ title }}
            </h2>
        </header>
        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Название" />

                <TextInput
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                />

                <InputError :message="form.errors.name" class="mt-2" />
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
                        Сохранено.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
