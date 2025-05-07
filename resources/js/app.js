import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import Main from "./Layouts/Main.vue";
import { setThemeOnLoad } from "./theme";
import messages from "./lang";
import { createI18n } from "vue-i18n";

const userLang = localStorage.getItem("locale") || "en";
const i18n = createI18n({
    legacy: false, // penting: agar bisa pakai $t
    // locale: window?.locale || "en",
    locale: userLang,
    fallbackLocale: "en",
    messages,
});

createInertiaApp({
    title: (title) => `Laravue${title ? " - " + title : ""}`,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = page.default.layout || Main;
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n)
            .component("Head", Head)
            .component("Link", Link)
            .mount(el);
    },
    progress: {
        // delay: 250,
        delay: 100,
        // color: "#29d",
        color: "#84cc16",
        // includeCSS: true,
        // includeCSS: false,
        showSpinner: false,
    },
});

setThemeOnLoad();
