<script setup>
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import {
    LayoutDashboard,
    UsersRound,
    IdCard,
    Network,
    MapPinHouse,
    LayoutTemplate,
    ChevronDown,
    ChevronRight,
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

const page = usePage();

const isActive = (path) => page.url === path;

const openDropdowns = ref({});

const toggleDropdown = (title) => {
    openDropdowns.value[title] = !openDropdowns.value[title];
};

const items = [
    {
        title: "Dashboard",
        icon: LayoutDashboard,
        to: "/dashboard",
    },
    {
        title: "Master Penduduk",
        icon: UsersRound,
        children: [
            {
                title: "Penduduk",
                to: "/penduduk",
            },
            {
                title: "Kematian",
                to: "/kematian",
            },
            {
                title: "Kelahiran",
                to: "/kelahiran",
            },
        ],
    },
    {
        title: "Perangkat Desa",
        icon: Network,
        to: "/perangkat-desa",
    },
    {
        title: "Keluarga",
        icon: IdCard,
        to: "/keluarga",
    },
    {
        title: "Data Desa",
        icon: MapPinHouse,
        to: "/desa",
    },
    {
        title: "Konten Web",
        icon: LayoutTemplate,
        children: [
            {
                title: "Berita",
                to: "/berita",
            },
        ],
    },
];
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
                </SidebarGroupContent>
            </SidebarGroup>
        </SidebarContent>
    </Sidebar>
</template>
