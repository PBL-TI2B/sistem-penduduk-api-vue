<script setup>
import { useForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

import { Button } from "@/components/ui/button";
import {
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import AppLayout from "@/Layouts/AppLayout.vue";
import { apiPost } from "@/utils/api";
import Cookies from "js-cookie";
import { toast } from "vue-sonner";

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
        const response = await apiPost("/login", {
            username: data.username,
            password: data.password,
        });
        Cookies.set("token", response.data.access_token, {
            expires: 1,
            secure: true,
            sameSite: "Strict",
        });
        toast.success("Login successful!");
    } catch (error) {
        console.error("Login failed:", error);
        // Handle login error, e.g., show an error message
    }
});

defineOptions({
    layout: AppLayout,
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
