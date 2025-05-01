<script setup>
import { cn } from "@/lib/utils";

const props = defineProps({
    class: { type: null, required: false },
});
</script>

<template>
    <div
        data-slot="sidebar-content"
        data-sidebar="content"
        :class="
            cn(
                'grid h-full gap-2 overflow-auto group-data-[collapsible=icon]:overflow-hidden',
                props.class
            )
        "
    >
        <slot />
    </div>
</template>
