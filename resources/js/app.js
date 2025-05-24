import "./bootstrap";

import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import MasterLayout from "@/Layouts/MasterLayout.vue";
import { ZiggyVue } from "ziggy-js";
// import { useCurrencyInput } from "vue-currency-input"

// Setup currency input options https://dm4t2.github.io/vue-currency-input/playground.html
// const optionsCurrency = {
//     globalOptions: {
        // locale: "id-ID",
        // currency: "IDR",
        // currencyDisplay: "hidden",
        // precision: {
        //   min: 2,
        //   max: 5
        // },
        // hideCurrencySymbolOnFocus: true,
        // hideGroupingSeparatorOnFocus: false,
        // hideNegligibleDecimalDigitsOnFocus: false,
        // autoDecimalDigits: false,
        // useGrouping: true,
        // accountingSign: true
//     },
// }

createInertiaApp({
    title: (title) => `Desa Jabung ${title}`,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        const page = pages[`./Pages/${name}.vue`];

        page.default.layout = page.default.layout || MasterLayout;

        return page;
    },
    progress: {
        delay: 250,
        color: "#0B391D",
        includeCSS: true,
        showSpinner: false,
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            // .use(useCurrencyInput, optionsCurrency)
            .component("Link", Link)
            .component("Head", Head)
            .mount(el);
    },
});
