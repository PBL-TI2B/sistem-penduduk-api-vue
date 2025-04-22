<script setup>
import { usePage } from "@inertiajs/vue3";
import {
    Calendar,
    Home,
    Inbox,
    Search,
    Settings,
    LayoutDashboard,
} from "lucide-vue-next";
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

const items = [
    {
        title: "Home",
        icon: Home,
        to: "/",
    },
    {
        title: "Dashboard",
        icon: LayoutDashboard,
        to: "/dashboard",
    },
    {
        title: "Penduduk",
        icon: Inbox,
        to: "/penduduk",
    },
    {
        title: "Calendar",
        icon: Calendar,
        to: "/calendar",
    },
    {
        title: "Search",
        icon: Search,
        to: "/search",
    },
    {
        title: "Settings",
        icon: Settings,
        to: "/settings",
    },
];

const page = usePage();

const isActive = (path) => page.url === path;
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
                            <SidebarMenuButton
                                asChild
                                :class="{
                                    'bg-sidebar-accent text-sidebar-accent-foreground':
                                        isActive(item.to),
                                }"
                            >
                                <Link :href="item.to">
                                    <component :is="item.icon" />
                                    <span class="ml-2">{{ item.title }}</span>
                                </Link>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </SidebarMenu>
                </SidebarGroupContent>
            </SidebarGroup>
        </SidebarContent>
    </Sidebar>
</template>
