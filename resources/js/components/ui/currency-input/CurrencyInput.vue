<template>
    <input
        ref="inputRef"
        type="text"
        :class="
            cn(
                'file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30 border-card flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm',
                'focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[1.5px]',
                'aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive',
                props.class,
            )
        "
        v-bind="inputAttrs"
    />
</template>

<script setup>
import { useCurrencyInput } from "vue-currency-input";
import { watchDebounced } from "@vueuse/core";
import { useAttrs } from "vue";
import { cn } from "@/lib/utils"; // from shadcn

const props = defineProps({
    modelValue: {
        type: Number,
        default: null,
    },
    options: {
        type: Object,
        default: () => ({
            locale: "id-ID",
            currency: "IDR",
            // currencyDisplay: 'hidden',
            // precision: {
            //   min: 2,
            //   max: 5
            // },
            hideCurrencySymbolOnFocus: false,
            hideGroupingSeparatorOnFocus: false,
            hideNegligibleDecimalDigitsOnFocus: false,
            autoDecimalDigits: false,
            useGrouping: true,
            accountingSign: true,
        }),
    },
    class: {
        type: null,
        required: false,
    },
});

const emit = defineEmits(["update:modelValue"]);
const inputAttrs = useAttrs();

// ✅ Default = auto format aktif
const { inputRef, numberValue, setValue } = useCurrencyInput(props.options);

// ✅ Sinkronkan dari luar jika modelValue berubah
watchDebounced(numberValue, (val) => emit("update:modelValue", val), {
    debounce: 500,
});
</script>
