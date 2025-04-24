import { toast } from "vue-sonner";

export function useErrorHandler(error, fallbackMessage = "Terjadi kesalahan.") {
    toast.error(fallbackMessage);

    if (import.meta.env.MODE === "development") {
        console.error("Error:", error);
    }
}
