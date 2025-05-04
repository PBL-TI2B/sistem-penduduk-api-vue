import { router } from "@inertiajs/vue3";
import { onBeforeMount } from "vue";
import { apiGet } from "@/utils/api";
import { useErrorHandler } from "./useErrorHandler";

export function useAuthGuard(requiredRole = null) {
    onBeforeMount(async () => {
        try {
            const res = await apiGet("/auth/me");
            const user = res.data;
            console.log(requiredRole);

            if (!user) return router.visit("/login");
            if (requiredRole && user.role !== requiredRole)
                return router.visit("/unauthorized");
        } catch (error) {
            useErrorHandler(error, "Token expired");
            router.visit("/login");
        }
    });
}
