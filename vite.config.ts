import { defineConfig } from 'vite';
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';
import laravel from 'vite-plugin-laravel';
import vue from '@vitejs/plugin-vue';
import eslint from 'vite-plugin-eslint';
import components from 'unplugin-vue-components/vite';
import inertia from './resources/js/Vite/inertia-layout';

export default defineConfig({
    plugins: [
        inertia(),
        components({
            dirs: ['resources/js/Components'],
            dts: 'resources/js/components.d.ts',
            directoryAsNamespace: true,
        }),
        eslint(),
        vue(),
        laravel({
            postcss: [tailwindcss(), autoprefixer()],
        }),
    ],
});
