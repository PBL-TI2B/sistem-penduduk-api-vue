<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import { apiPost } from "@/utils/api";
import Cookies from "js-cookie";

import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { Button } from "@/components/ui/button";
import { Avatar, AvatarFallback } from "@/components/ui/avatar";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const isLoading = ref(false);

const logout = async () => {
    if (isLoading.value) return;

    isLoading.value = true;
    try {
        await apiPost("/auth/logout");
        Cookies.remove("token");
        router.visit("/login");
    } catch (error) {
        console.error("Logout error:", error);
        // Even if logout API fails, remove token and redirect
        Cookies.remove("token");
        router.visit("/login");
    } finally {
        isLoading.value = false;
    }
};

const goToChangePassword = () => {
    router.visit("/admin/change-password");
};

const goToProfile = () => {
    router.visit("/admin/profile");
};

// Get user initials for avatar
const getUserInitials = (username) => {
    if (!username) return "U";
    return username.substring(0, 2).toUpperCase();
};
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger asChild>
            <Button variant="ghost" class="relative h-10 w-10 rounded-full">
                <Avatar class="h-10 w-10">
                    <AvatarFallback
                        class="bg-emerald-100 text-emerald-700 font-semibold"
                    >
                        {{ getUserInitials(user.username) }}
                    </AvatarFallback>
                </Avatar>
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent class="w-56" align="end" forceMount>
            <DropdownMenuLabel class="font-normal">
                <div class="flex flex-col space-y-1">
                    <p class="text-sm font-medium leading-none">
                        {{ user.username }}
                    </p>
                    <p
                        class="text-xs leading-none text-muted-foreground capitalize"
                    >
                        {{ user.role || "User" }}
                    </p>
                </div>
            </DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuItem @click="goToProfile" class="cursor-pointer">
                <svg
                    class="mr-2 h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />
                </svg>
                <span>Profil</span>
            </DropdownMenuItem>
            <DropdownMenuItem
                @click="goToChangePassword"
                class="cursor-pointer"
            >
                <svg
                    class="mr-2 h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 7a2 2 0 012 2m0 0a2 2 0 012 2m-2-2a2 2 0 00-2 2m2-2V5a2 2 0 00-2-2H9a2 2 0 00-2 2v2a2 2 0 002 2m6 0V9a2 2 0 012 2m-2-2a2 2 0 00-2-2m2 2v4a2 2 0 01-2 2H9a2 2 0 01-2-2V9a2 2 0 012-2m0 0V5a2 2 0 012-2h4a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 01-2-2z"
                    />
                </svg>
                <span>Ganti Password</span>
            </DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem
                @click="logout"
                class="cursor-pointer text-red-600 focus:text-red-600"
                :disabled="isLoading"
            >
                <svg
                    class="mr-2 h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                    />
                </svg>
                <span>{{ isLoading ? "Logout..." : "Logout" }}</span>
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
