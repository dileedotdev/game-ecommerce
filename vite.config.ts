import { defineConfig } from "vite";
import tailwindcss from "tailwindcss";
import autoprefixer from "autoprefixer";
import laravel from "vite-plugin-laravel";
import vue from "@vitejs/plugin-vue";
import inertia from "./resources/js/Vite/inertia-layout";

export default defineConfig({
    plugins: [
        inertia(),
        vue(),
        laravel({
            postcss: [tailwindcss(), autoprefixer()],
        }),
    ],
});
