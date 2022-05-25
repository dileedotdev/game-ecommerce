import './bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import route from 'ziggy-js';

import { importPageComponent } from './Vite/import-page-component';

createInertiaApp({
    title: (title) => `${title} - ${import.meta.env.VITE_APP_NAME}`,
    resolve: (name) => importPageComponent(name),
    setup({ el, app, props, plugin }) {
        const createdApp = createApp({ render: () => h(app, props) }).use(
            plugin
        );

        createdApp.config.globalProperties.$route = route;
        createdApp.config.globalProperties.route = route; // Used by jetstream components
        createdApp.component('InertiaLink', Link);

        createdApp.mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
