import { usePage } from "@inertiajs/vue3";

export function usePermission() {
    const hasRole = () => usePage().props.auth.user.roles.includes(name);
    const hasPermission = () =>
        usePage().props.auth.user.permissions.includes(name);

    return { hasRole, hasPermission };
}
