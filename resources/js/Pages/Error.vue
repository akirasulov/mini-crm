<template>
    <Head title="Ошибка" />
    <section class="bg-white dark:bg-gray-900">
        <div
            class="container mx-auto flex min-h-screen items-center px-6 py-12"
        >
            <div>
                <p class="text-sm font-medium text-blue-500 dark:text-blue-400">
                    Ошибка, что то пошло не так
                </p>
                <h1
                    class="mt-3 text-2xl font-semibold text-gray-800 md:text-3xl dark:text-white"
                >
                    {{ title }}
                </h1>
                <p class="mt-4 text-gray-500 dark:text-gray-400">
                    {{ description }}
                </p>

                <div class="mt-6 flex items-center gap-x-3">
                    <Link
                        href="/"
                        class="flex w-1/2 items-center justify-center gap-x-2 rounded-lg border bg-white px-5 py-2 text-sm text-gray-700 transition-colors duration-200 hover:bg-gray-100 sm:w-auto dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-5 w-5 rtl:rotate-180"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18"
                            />
                        </svg>

                        <span>Назад</span>
                    </Link>

                    <Link
                        href="/"
                        class="w-1/2 shrink-0 rounded-lg bg-blue-500 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 hover:bg-blue-600 sm:w-auto dark:bg-blue-600 dark:hover:bg-blue-500"
                    >
                        На главную
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    layout: null,
    props: {
        status: Number,
    },
    computed: {
        title() {
            return {
                503: "503: Сервис недоступен",
                500: "500: Ошибка сервера",
                404: "404: Страница не найдена",
                403: "403: Доступ запрещен",
            }[this.status];
        },
        description() {
            return {
                503: "Извините, мы проводим техническое обслуживание. Пожалуйста, зайдите в ближайшее время.",
                500: "Ой, что-то пошло не так.",
                404: "К сожалению, страница, которую вы ищете, не может быть найдена.",
                403: "Извините, вам запрещен доступ к этой странице.",
            }[this.status];
        },
    },
};
</script>
