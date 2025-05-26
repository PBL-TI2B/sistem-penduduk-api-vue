<script setup>
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from "@/components/ui/alert-dialog";

const props = defineProps({
    isOpen: Boolean,
    title: String,
    description: String,
    onConfirm: Function,
    onCancel: Function,
});

const emit = defineEmits(["update:isOpen"]);
</script>

<template>
    <AlertDialog
        :open="props.isOpen"
        @openChange="emit('update:isOpen', $event)"
    >
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>{{ props.title }}</AlertDialogTitle>
                <AlertDialogDescription>
                    {{ props.description }}
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel @click="props.onCancel"
                    >Batal</AlertDialogCancel
                >
                <AlertDialogAction @click="props.onConfirm"
                    >Ya</AlertDialogAction
                >
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
