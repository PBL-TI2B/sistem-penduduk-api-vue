<script setup>
import { SidebarProvider, SidebarTrigger } from "@/components/ui/sidebar";
import AppSidebar from "@/components/AppSidebar.vue";
</script>

<template>
    <div class="flex">
        <SidebarProvider>
            <AppSidebar />
            <main class="flex-1 my-8">
                <SidebarTrigger class="md:hidden" />
                <slot />
            </main>
        </SidebarProvider>
    </div>
</template>
