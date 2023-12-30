import "./bootstrap";
import "../css/app.css";
import "vue-toastification/dist/index.css";

import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { notifications } from "./Plugins/notifications";
import Toast from "vue-toastification";

const appName = import.meta.env.VITE_APP_NAME || "CRM";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue"),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(Toast)
            .use(notifications)
            .component("Link", Link)
            .component("Head", Head)
            .mount(el);
    },
    progress: {
        color: "#00b956",
        showSpinner: true,
    },
});
