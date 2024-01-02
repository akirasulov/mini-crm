<script setup>
import { computed, onMounted, reactive } from "vue";
import { initFlowbite } from "flowbite";
import {
    UsersIcon,
    UserCircleIcon,
    HomeIcon,
    DocumentDuplicateIcon,
    ShieldCheckIcon,
} from "@heroicons/vue/24/solid";

import SideBar from "@/Components/SideBar.vue";
import ThemeToogle from "@/Components/ThemeToogle.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { usePermission } from "@/Composables/permissions";
const { checkpermission } = usePermission();
onMounted(() => {
    initFlowbite();
});
defineOptions({
    inheritAttrs: false,
});
const navigation = reactive([
    {
        route: "index",
        icon: HomeIcon,
        name: "Главная",
        can: checkpermission.canCreatePost,
    },
    {
        route: "users.index",
        icon: UsersIcon,
        name: "Пользователи",
        can: checkpermission.canViewUser,
    },
    {
        route: "posts.index",
        icon: DocumentDuplicateIcon,
        name: "Обращения",
        can: checkpermission.canViewPost,
    },
    {
        route: "permissios.index",
        icon: ShieldCheckIcon,
        name: "Роли и разрешения",
        can: checkpermission.isAdmin,
    },
]);
</script>

<template>
    <nav
        class="fixed top-0 z-50 w-full border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800"
    >
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button
                        data-drawer-target="logo-sidebar"
                        data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar"
                        type="button"
                        class="inline-flex items-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 sm:hidden dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    >
                        <span class="sr-only">Open sidebar</span>
                        <svg
                            class="h-6 w-6"
                            aria-hidden="true"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                clip-rule="evenodd"
                                fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
                            ></path>
                        </svg>
                    </button>
                    <Link :href="route('index')" class="ms-2 flex md:me-24">
                        <ApplicationLogo />
                    </Link>
                </div>
                <div class="flex items-center">
                    <ThemeToogle />
                    <div class="ms-3 flex items-center">
                        <div>
                            <button
                                type="button"
                                class="flex rounded-full bg-gray-800 text-sm focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false"
                                data-dropdown-toggle="dropdown-user"
                            >
                                <span class="sr-only">Open user menu</span>
                                <img
                                    v-if="
                                        $page.props.auth.user.profile_photo_path
                                    "
                                    class="h-8 w-8 rounded-full"
                                    :src="
                                        $page.props.auth.user.profile_photo_path
                                    "
                                    :alt="$page.props.auth.user.email"
                                />
                                <UserCircleIcon
                                    v-else
                                    class="h-8 w-8 rounded-full text-gray-300"
                                    aria-hidden="true"
                                />
                            </button>
                        </div>

                        <div
                            class="z-50 my-4 hidden list-none divide-y divide-gray-100 rounded bg-white text-base shadow dark:divide-gray-600 dark:bg-gray-700"
                            id="dropdown-user"
                        >
                            <div class="px-4 py-3" role="none">
                                <p
                                    class="text-sm text-gray-900 dark:text-white"
                                    role="none"
                                >
                                    {{ $page.props.auth.user.surname }}
                                    {{ $page.props.auth.user.name }}
                                </p>
                                <p
                                    class="truncate text-sm font-medium text-gray-900 dark:text-gray-300"
                                    role="none"
                                >
                                    {{ $page.props.auth.user.email }}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <Link
                                        :href="route('profile.edit')"
                                        class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem"
                                        >Аккаунт</Link
                                    >
                                </li>
                                <li>
                                    <Link
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem"
                                        >Выход</Link
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <SideBar :navigation="navigation" />

    <main v-bind="$attrs" class="bg-white px-4 pt-20 sm:ml-64 dark:bg-gray-800">
        <slot />
    </main>
</template>
