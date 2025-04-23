<script setup>
import { cn } from "@/lib/utils";

const props = defineProps({
    class: { type: null, required: false },
});
</script>

<template>
    <tr
        data-slot="table-row"
        :class="
            cn(
                'data-[state=selected]:bg-muted border-b border-card transition-colors even:bg-card/40',
                props.class
            )
        "
    >
        <slot />
    </tr>
</template>
