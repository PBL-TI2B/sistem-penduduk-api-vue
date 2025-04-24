<script setup>
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from "@/components/ui/breadcrumb";

defineProps({
    items: {
        type: Array,
    },
});
</script>

<template>
    <Breadcrumb>
        <BreadcrumbList>
            <template v-for="(item, index) in items" :key="index">
                <BreadcrumbItem>
                    <template v-if="item.href">
                        <BreadcrumbLink asChild>
                            <Link :href="item.href">
                                {{ item.label }}
                            </Link>
                        </BreadcrumbLink>
                    </template>
                    <template v-else>
                        <BreadcrumbPage>
                            {{ item.label }}
                        </BreadcrumbPage>
                    </template>
                </BreadcrumbItem>
                <BreadcrumbSeparator v-if="index < items.length - 1" />
            </template>
        </BreadcrumbList>
    </Breadcrumb>
</template>
