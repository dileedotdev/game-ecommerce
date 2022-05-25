import { DefineComponent } from "vue";
import { createHeadManager, Inertia, Page } from "@inertiajs/inertia";
import route from "ziggy-js";
import { Link } from "@inertiajs/inertia-vue3";

// This is required for Visual Studio Code to recognize
// imported .vue files
declare module "*.vue" {
    const component: DefineComponent<{}, {}, any>;
    export default component;
}

declare module "@vue/runtime-core" {
    export interface ComponentCustomProperties {
        $route: typeof route;
        $inertia: typeof Inertia;
        $page: Page;
        $headManager: ReturnType<typeof createHeadManager>;
    }

    export interface GlobalComponents {
        InertiaLink: typeof Link;
    }
}
