<script setup>
import { useForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";
import { apiPost } from "@/utils/api";
import { ref } from "vue";

import { Button } from "@/components/ui/button";
import {
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { router } from "@inertiajs/vue3";

// Assuming you have an AdminLayout or similar
// import AdminLayout from "@/Layouts/AdminLayout.vue";

const isLoading = ref(false);
const isSuccess = ref(false);

const formSchema = toTypedSchema(
    z
        .object({
            current_password: z.string().min(1, "Password lama harus diisi"),
            new_password: z
                .string()
                .min(8, "Password baru minimal 8 karakter")
                .max(50),
            new_password_confirmation: z
                .string()
                .min(8, "Konfirmasi password minimal 8 karakter"),
        })
        .refine(
            (data) => data.new_password === data.new_password_confirmation,
            {
                message: "Konfirmasi password tidak sama",
                path: ["new_password_confirmation"],
            }
        )
);

const form = useForm({
    validationSchema: formSchema,
});

const onSubmit = form.handleSubmit(async () => {
    const data = form.values;
    isLoading.value = true;

    try {
        const response = await apiPost("/auth/change-password", {
            current_password: data.current_password,
            new_password: data.new_password,
            new_password_confirmation: data.new_password_confirmation,
        });

        if (response.success === true) {
            isSuccess.value = true;
            form.resetForm();

            // Auto hide success message after 3 seconds
            setTimeout(() => {
                isSuccess.value = false;
            }, 3000);
        } else {
            useErrorHandler(
                new Error(response.message),
                "Gagal mengubah password"
            );
        }
    } catch (error) {
        useErrorHandler(error, "Gagal mengubah password");
    } finally {
        isLoading.value = false;
    }
});

const goBack = () => {
    router.visit("/admin/dashboard");
};

// defineOptions({
//     layout: AdminLayout,
// });
</script>

<template>
    <Head title=" - Ganti Password" />

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto">
            <!-- Success Alert -->
            <div
                v-if="isSuccess"
                class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg"
            >
                <div class="flex items-center">
                    <svg
                        class="w-5 h-5 text-green-600 mr-2"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        ></path>
                    </svg>
                    <p class="text-green-800 font-medium">
                        Password berhasil diubah!
                    </p>
                </div>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle class="text-center">Ganti Password</CardTitle>
                    <p class="text-gray-500 text-center text-sm">
                        Masukkan password lama dan password baru
                    </p>
                </CardHeader>
                <CardContent>
                    <form @submit="onSubmit" class="grid gap-6">
                        <FormField
                            v-slot="{ componentField }"
                            name="current_password"
                        >
                            <FormItem>
                                <FormLabel class="text-gray-700"
                                    >Password Lama</FormLabel
                                >
                                <FormControl>
                                    <Input
                                        type="password"
                                        placeholder="Masukkan Password Lama"
                                        class="placeholder:text-gray-400"
                                        v-bind="componentField"
                                    />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>

                        <FormField
                            v-slot="{ componentField }"
                            name="new_password"
                        >
                            <FormItem>
                                <FormLabel class="text-gray-700"
                                    >Password Baru</FormLabel
                                >
                                <FormControl>
                                    <Input
                                        type="password"
                                        placeholder="Masukkan Password Baru"
                                        class="placeholder:text-gray-400"
                                        v-bind="componentField"
                                    />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>

                        <FormField
                            v-slot="{ componentField }"
                            name="new_password_confirmation"
                        >
                            <FormItem>
                                <FormLabel class="text-gray-700"
                                    >Konfirmasi Password Baru</FormLabel
                                >
                                <FormControl>
                                    <Input
                                        type="password"
                                        placeholder="Konfirmasi Password Baru"
                                        class="placeholder:text-gray-400"
                                        v-bind="componentField"
                                    />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>

                        <div class="grid gap-2 mt-4">
                            <Button
                                type="submit"
                                class="w-full"
                                :disabled="isLoading"
                            >
                                {{
                                    isLoading ? "Menyimpan..." : "Ubah Password"
                                }}
                            </Button>
                            <Button
                                type="button"
                                variant="outline"
                                @click="goBack"
                                class="w-full"
                            >
                                Kembali
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>

            <!-- Password Requirements Info -->
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h4 class="text-sm font-medium text-blue-800 mb-2">
                    Syarat Password:
                </h4>
                <ul class="text-xs text-blue-700 space-y-1">
                    <li>• Minimal 8 karakter</li>
                    <li>
                        • Password baru tidak boleh sama dengan password lama
                    </li>
                    <li>
                        • Konfirmasi password harus sama dengan password baru
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
