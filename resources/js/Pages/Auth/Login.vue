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
        if (user) router.visit("/dashboard");
    } catch (e) {
        // user not logged in → biarkan tetap di halaman login
    }
});
const formSchema = toTypedSchema(
    z.object({
        username: z.string().min(2).max(50),
        password: z.string().min(8).max(50),
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

        if (response.success === true) {
            router.visit("/dashboard");
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
    <div class="grid place-items-center h-screen bg-gray-100">
        <div class="w-full max-w-sm p-6 rounded-lg shadow-md">
            <form @submit="onSubmit">
                <FormField v-slot="{ componentField }" name="username">
                    <FormItem>
                        <FormLabel>Username</FormLabel>
                        <FormControl>
                            <Input
                                type="text"
                                placeholder="Masukkan Username"
                                v-bind="componentField"
                            />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <FormField v-slot="{ componentField }" name="password">
                    <FormItem>
                        <FormLabel>Password</FormLabel>
                        <FormControl>
                            <Input
                                type="password"
                                placeholder="Masukkan Password"
                                v-bind="componentField"
                            />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <Button type="submit" class="my-4"> Submit </Button>
            </form>
        </div>
    </div>
</template>
