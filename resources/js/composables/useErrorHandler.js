import { toast } from "vue-sonner";

export function useErrorHandler(error, fallbackMessage = "Terjadi kesalahan.") {
    toast.error(fallbackMessage, {
        duration: 2000, // dalam milidetik, misal 2000 = 2 detik
    });

    if (import.meta.env.MODE === "development") {
        console.error("Error:", error);
    }
}
