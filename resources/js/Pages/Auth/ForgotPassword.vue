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
import LoginLayout from "@/Layouts/LoginLayout.vue";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { router } from "@inertiajs/vue3";

const step = ref(1); // 1 = input username, 2 = input token, 3 = success
const resetToken = ref("");
const username = ref("");
const isLoading = ref(false);

// Form untuk request token
const requestFormSchema = toTypedSchema(
    z.object({
        username: z.string().min(4, "Username minimal 4 Karakter").max(50),
    })
);

const requestForm = useForm({
    validationSchema: requestFormSchema,
});

// Form untuk reset password dengan token
const resetFormSchema = toTypedSchema(
    z.object({
        username: z.string().min(4, "Username minimal 4 Karakter").max(50),
        token: z.string().min(1, "Token harus diisi"),
    })
);

const resetForm = useForm({
    validationSchema: resetFormSchema,
});

const onRequestToken = requestForm.handleSubmit(async () => {
    const data = requestForm.values;
    isLoading.value = true;

    try {
        const response = await apiPost("/auth/request-password-reset", {
            username: data.username,
        });

        if (response.success === true) {
            resetToken.value = response.data.reset_token;
            username.value = data.username;

            // Set values untuk form kedua
            resetForm.setValues({
                username: data.username,
                token: "",
            });

            step.value = 2;
        } else {
            useErrorHandler(
                new Error(response.message),
                "Gagal membuat token reset"
            );
        }
    } catch (error) {
        useErrorHandler(error, "Gagal membuat token reset");
    } finally {
        isLoading.value = false;
    }
});

const onResetPassword = resetForm.handleSubmit(async () => {
    const data = resetForm.values;
    isLoading.value = true;

    try {
        const response = await apiPost("/auth/reset-password-default", {
            username: data.username,
            token: data.token,
        });

        if (response.success === true) {
            step.value = 3;
        } else {
            useErrorHandler(
                new Error(response.message),
                "Gagal reset password"
            );
        }
    } catch (error) {
        useErrorHandler(error, "Gagal reset password");
    } finally {
        isLoading.value = false;
    }
});

const backToLogin = () => {
    router.visit("/login");
};

const backToStep1 = () => {
    step.value = 1;
    resetToken.value = "";
    username.value = "";
    requestForm.resetForm();
    resetForm.resetForm();
};

defineOptions({
    layout: LoginLayout,
});
</script>

<template>
    <Head title=" - Reset Password" />
    <div
        class="grid place-items-center h-screen bg-gradient-to-b from-emerald-500 to-emerald-700"
    >
        <div class="grid gap-y-4">
            <div>
                <h2 class="text-2xl font-bold text-white text-center">
                    Desa Jabung
                </h2>
                <p class="text-white text-center">
                    Sistem Informasi Kependudukan
                </p>
            </div>

            <!-- Step 1: Input Username -->
            <div
                v-if="step === 1"
                class="min-w-md h-max p-6 rounded-lg shadow-md bg-white"
            >
                <div class="text-center mb-8">
                    <h3 class="text-xl font-semibold">Reset Password</h3>
                    <p class="text-gray-500">
                        Masukkan username untuk mendapatkan token reset password
                    </p>
                </div>
                <form @submit="onRequestToken" class="grid gap-6">
                    <FormField v-slot="{ componentField }" name="username">
                        <FormItem>
                            <FormLabel class="text-gray-700"
                                >Username</FormLabel
                            >
                            <FormControl>
                                <Input
                                    type="text"
                                    placeholder="Masukkan Username"
                                    class="placeholder:text-gray-600"
                                    v-bind="componentField"
                                />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <div class="grid gap-2 my-4">
                        <Button
                            variant="frontend"
                            type="submit"
                            class="w-full"
                            :disabled="isLoading"
                        >
                            {{
                                isLoading
                                    ? "Memproses..."
                                    : "Dapatkan Token Reset"
                            }}
                        </Button>
                        <Button
                            :isChild="true"
                            type="button"
                            @click="backToLogin"
                            class="w-full bg-transparent border border-gray-400 text-gray-700 hover:bg-gray-100 rounded-full"
                        >
                            Kembali ke Login
                        </Button>
                    </div>
                </form>
            </div>

            <!-- Step 2: Input Token -->
            <div
                v-if="step === 2"
                class="min-w-md h-max p-6 rounded-lg shadow-md bg-white"
            >
                <div class="text-center mb-8">
                    <h3 class="text-xl font-semibold">Masukkan Token Reset</h3>
                    <p class="text-gray-500">
                        Token reset password untuk username:
                        <strong>{{ username }}</strong>
                    </p>
                </div>

                <!-- Show token -->
                <div
                    class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6"
                >
                    <div class="text-center">
                        <p class="text-sm text-yellow-800 mb-2">
                            Token Reset Password:
                        </p>
                        <p
                            class="text-lg font-mono font-bold text-yellow-900 tracking-wider"
                        >
                            {{ resetToken }}
                        </p>
                        <p class="text-xs text-yellow-700 mt-2">
                            Token akan expired dalam 24 jam
                        </p>
                    </div>
                </div>

                <form @submit="onResetPassword" class="grid gap-6">
                    <FormField v-slot="{ componentField }" name="username">
                        <FormItem>
                            <FormLabel class="text-gray-700"
                                >Username</FormLabel
                            >
                            <FormControl>
                                <Input
                                    type="text"
                                    class="bg-gray-100"
                                    readonly
                                    v-bind="componentField"
                                />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="token">
                        <FormItem>
                            <FormLabel class="text-gray-700"
                                >Token Reset</FormLabel
                            >
                            <FormControl>
                                <Input
                                    type="text"
                                    placeholder="Masukkan Token Reset"
                                    class="placeholder:text-gray-600 font-mono tracking-wider"
                                    v-bind="componentField"
                                />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <div class="grid gap-2 my-4">
                        <Button
                            variant="frontend"
                            type="submit"
                            class="w-full"
                            :disabled="isLoading"
                        >
                            {{ isLoading ? "Memproses..." : "Reset Password" }}
                        </Button>
                        <Button
                            :isChild="true"
                            type="button"
                            @click="backToStep1"
                            class="w-full bg-transparent border border-gray-400 text-gray-700 hover:bg-gray-100 rounded-full"
                        >
                            Kembali
                        </Button>
                    </div>
                </form>
            </div>

            <!-- Step 3: Success -->
            <div
                v-if="step === 3"
                class="min-w-md h-max p-6 rounded-lg shadow-md bg-white"
            >
                <div class="text-center mb-8">
                    <div
                        class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4"
                    >
                        <svg
                            class="w-8 h-8 text-green-600"
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
                    </div>
                    <h3 class="text-xl font-semibold text-green-600">
                        Password Berhasil Direset!
                    </h3>
                    <p class="text-gray-500 mt-2">
                        Password Anda telah direset ke password default
                    </p>
                </div>

                <div
                    class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6"
                >
                    <div class="text-center">
                        <p class="text-sm text-blue-800 mb-2">
                            Password Default:
                        </p>
                        <p
                            class="text-lg font-mono font-bold text-blue-900 tracking-wider"
                        >
                            password123
                        </p>
                        <p class="text-xs text-blue-700 mt-2">
                            Silahkan login dan ubah password Anda
                        </p>
                    </div>
                </div>

                <div class="grid gap-2">
                    <Button
                        variant="frontend"
                        @click="backToLogin"
                        class="w-full"
                    >
                        Login Sekarang
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>
