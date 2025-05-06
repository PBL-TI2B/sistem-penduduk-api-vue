<script setup>
import { ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { ChevronDown, ChevronRight, LogOut } from "lucide-vue-next";
import {
    Sidebar,
    SidebarContent,
    SidebarGroup,
    SidebarGroupContent,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from "@/components/ui/sidebar";
import Button from "../../ui/button/Button.vue";
import { useErrorHandler } from "@/composables/useErrorHandler";
import Cookies from "js-cookie";
import { apiPost } from "@/utils/api";
import { items } from "./sidebarItems";

const page = usePage();

const isActive = (path) => page.url === path;

const openDropdowns = ref({});

const toggleDropdown = (title) => {
    openDropdowns.value[title] = !openDropdowns.value[title];
};

const logout = async () => {
    try {
        const res = await apiPost("/auth/logout");
        if (res.success) {
            Cookies.remove("token");
            router.visit("/");
        }
    } catch (error) {
        useErrorHandler(error, "Gagal keluar");
    }
};
</script>

<template>
    <Sidebar>
        <SidebarContent>
            <SidebarGroup>
                <SidebarHeader>
                    <div>
                        <h1 class="text-2xl font-bold">Desa Jabung</h1>
                        <p class="text-sm text-muted">Informasi Kependudukan</p>
                    </div>
                </SidebarHeader>
                <SidebarGroupContent>
                    <SidebarMenu>
                        <SidebarMenuItem
                            v-for="item in items"
                            :key="item.title"
                        >
                            <!-- If item has children (dropdown) -->
                            <template v-if="item.children">
                                <SidebarMenuButton
                                    asChild
                                    @click="toggleDropdown(item.title)"
                                    class="flex items-center justify-between"
                                >
                                    <div
                                        class="flex justify-between items-center gap-2"
                                    >
                                        <div class="flex items-center gap-4">
                                            <component
                                                :is="item.icon"
                                                class="w-4 h-4"
                                            />
                                            <span>{{ item.title }}</span>
                                        </div>
                                        <div>
                                            <component
                                                :is="
                                                    openDropdowns[item.title]
                                                        ? ChevronDown
                                                        : ChevronRight
                                                "
                                                class="w-4 h-4"
                                            />
                                        </div>
                                    </div>
                                </SidebarMenuButton>

                                <!-- Submenu -->
                                <div
                                    v-if="openDropdowns[item.title]"
                                    class="ml-6 mt-1"
                                >
                                    <SidebarMenuItem
                                        v-for="child in item.children"
                                        :key="child.title"
                                    >
                                        <SidebarMenuButton
                                            asChild
                                            :class="{
                                                'my-1 bg-sidebar-accent text-sidebar-accent-foreground':
                                                    isActive(child.to),
                                            }"
                                        >
                                            <Link :href="child.to">
                                                <span>{{ child.title }}</span>
                                            </Link>
                                        </SidebarMenuButton>
                                    </SidebarMenuItem>
                                </div>
                            </template>

                            <!-- Normal item (no dropdown) -->
                            <template v-else>
                                <SidebarMenuButton
                                    asChild
                                    :class="{
                                        'bg-sidebar-accent text-sidebar-accent-foreground':
                                            isActive(item.to),
                                    }"
                                >
                                    <Link :href="item.to">
                                        <component :is="item.icon" />
                                        <span class="ml-2">{{
                                            item.title
                                        }}</span>
                                    </Link>
                                </SidebarMenuButton>
                            </template>
                        </SidebarMenuItem>
                    </SidebarMenu>
                    <Button
                        class="absolute bottom-2 w-[93%]"
                        variant="secondary"
                        @click="logout"
                    >
                        <LogOut />
                        <span> Keluar </span>
                    </Button>
                </SidebarGroupContent>
            </SidebarGroup>
        </SidebarContent>
    </Sidebar>
</template>
