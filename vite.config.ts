import { defineConfig } from "vite";
import tailwindcss from "tailwindcss";
import autoprefixer from "autoprefixer";
import laravel from "vite-plugin-laravel";
import vue from "@vitejs/plugin-vue";
import eslint from "vite-plugin-eslint";
import inertia from "./resources/js/Vite/inertia-layout";

export default defineConfig({
    plugins: [
        eslint(),
        inertia(),
        vue(),
        laravel({
            postcss: [tailwindcss(), autoprefixer()],
        }),
    ],
});
