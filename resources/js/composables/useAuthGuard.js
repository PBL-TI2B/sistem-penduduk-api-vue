import { onBeforeMount } from "vue";
import { useErrorHandler } from "./useErrorHandler";
import { router } from "@inertiajs/vue3";
import { apiGet } from "@/utils/api";

export function useAuthGuard(requiredRoles = []) {
    onBeforeMount(async () => {
        try {
            const res = await apiGet("/auth/me");
            const user = res.data;

            if (!user) {
                return router.visit("/login");
            }

            console.log(user);
            const roles = user?.role ?? [];
            const required = Array.isArray(requiredRoles)
                ? requiredRoles
                : [requiredRoles]; // jaga-jaga kalau lupa pakai array

            const hasRole =
                required.length === 0 ||
                required.some((r) => roles.includes(r));

            if (!hasRole) {
                useErrorHandler("Unauthorized!");
            }
        } catch (error) {
            useErrorHandler(error, "Token expired");
            router.visit("/login");
        }
    });
}
