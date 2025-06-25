<!-- components/ToastViewer.vue -->
<template>
    <div ref="viewerRoot" />
</template>

<script setup>
import { onMounted, onBeforeUnmount, ref, watch } from "vue";
import Viewer from "@toast-ui/editor/dist/toastui-editor-viewer";
import "@toast-ui/editor/dist/toastui-editor-viewer.css";

const props = defineProps({
    content: { type: String, default: "" },
});

const viewerRoot = ref(null);
let viewerInstance = null;

onMounted(() => {
    viewerInstance = new Viewer({
        el: viewerRoot.value,
        initialValue: props.content,
    });
});

onBeforeUnmount(() => {
    viewerInstance?.destroy();
});

watch(
    () => props.content,
    (newVal) => {
        viewerInstance?.setMarkdown(newVal);
    }
);
</script>

<style scoped>
:deep(.toastui-editor-contents) {
    font-size: 0.9rem;
    line-height: 1.75rem;
}
</style>
