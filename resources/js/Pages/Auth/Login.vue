<script setup>
import { useForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";
import { apiGet, apiPost } from "@/utils/api";
import Cookies from "js-cookie";

import { Button } from "@/components/ui/button";
import {
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
// import PublicLayout from "@/Layouts/PublicLayout.vue";
import LoginLayout from "@/Layouts/LoginLayout.vue";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { router } from "@inertiajs/vue3";
import { onBeforeMount } from "vue";

onBeforeMount(async () => {
    try {
        const res = await apiGet("/auth/me");
        const user = res.data;
        if (user) router.visit("/admin/dashboard");
    } catch (e) {
        // user not logged in → biarkan tetap di halaman login
    }
});
const formSchema = toTypedSchema(
    z.object({
        username: z.string().min(4, "Username minimal 4 Karakter").max(50),
        password: z.string().min(8, "Password minimal 8 karakter").max(50),
    })
);

const form = useForm({
    validationSchema: formSchema,
});

const onSubmit = form.handleSubmit(async () => {
    const data = form.values;
    try {
        const response = await apiPost("/auth/login", {
            username: data.username,
            password: data.password,
        });
        console.log("Response login:", response);

        Cookies.set("token", response.data.access_token, {
            expires: 1,
            secure: false,
            sameSite: "Lax",
        });

        if (response.success === false) {
            useErrorHandler(new Error(response.message), "Login gagal");
            return;
        }

        if (response.success === true) {
            router.visit("/admin/dashboard");
        }
    } catch (error) {
        useErrorHandler(error, "Login gagal");
    }
});

defineOptions({
    // layout: PublicLayout,
    layout: LoginLayout,
});
</script>

<template>
    <Head title=" - Masuk" />
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
            <div class="min-w-md h-max p-6 rounded-lg shadow-md bg-white">
                <div class="text-center mb-8">
                    <h3 class="text-xl font-semibold">Masuk ke akunmu</h3>
                    <p class="text-gray-500">
                        Masukkan username dan password di bawah ini
                    </p>
                </div>
                <form @submit="onSubmit" class="grid gap-6">
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
                    <FormField v-slot="{ componentField }" name="password">
                        <FormItem>
                            <FormLabel class="text-gray-700"
                                >Password</FormLabel
                            >
                            <FormControl>
                                <Input
                                    type="password"
                                    placeholder="Masukkan Password"
                                    class="placeholder:text-gray-600"
                                    v-bind="componentField"
                                />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <div class="grid gap-2 my-4">
                        <Button variant="frontend" type="submit" class="w-full">
                            Masuk
                        </Button>
                        <Button
                            :isChild="true"
                            class="w-full bg-transparent border border-gray-400 text-gray-700 hover:bg-gray-100 rounded-full"
                        >
                            <Link href="/" class="w-full"> Kembali </Link>
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
