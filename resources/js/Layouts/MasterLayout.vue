<script setup>
import { SidebarProvider, SidebarTrigger } from "@/components/ui/sidebar";
import AppSidebar from "@/components/master/sidebar/AppSidebar.vue";
import { Toaster } from "vue-sonner";
import { useAuthGuard } from "@/composables/useAuthGuard";

useAuthGuard(["admin", "superadmin", "rt", "rw"]);
</script>

<template>
    <div class="flex">
        <SidebarProvider>
            <AppSidebar />
            <main class="flex-1 my-2 px-8">
                <SidebarTrigger class="lg:hidden" />
                <slot />
            </main>
        </SidebarProvider>
    </div>
    <Toaster position="top-right" />
</template>
