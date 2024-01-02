import { usePage } from "@inertiajs/vue3";
import { reactive } from "vue";

export function usePermission() {
    const hasRole = (name) =>
        usePage().props.auth.user.roles.some((permission) =>
            permission.name.includes(name),
        );
    const hasPermission = (name) =>
        usePage().props.auth.user.permissions.some((permission) =>
            permission.name.includes(name),
        );
    const checkpermission = reactive({
        canCreateUser: hasPermission("create user"),
        canUpdateUser: hasPermission("update user"),
        canDeleteUser: hasPermission("delete user"),
        canViewUser: hasPermission("view user"),
        canCreatePost: hasPermission("create post"),
        canUpdatePost: hasPermission("update post"),
        canUpdatePostStatus: hasPermission("update post status"),
        canDeletePost: hasPermission("delete post"),
        canViewPost: hasPermission("view post"),
        canLeaveComment: hasPermission("leave commemt"),
        canGrantRole: hasPermission("grant a role"),
        canChangeResponsible: hasPermission("change responsible"),
        canRoleAndPermission: hasPermission("create role and permission"),
        isAdmin: hasRole("admin"),
        isClient: hasRole("client"),
    });

    return { checkpermission };
}
