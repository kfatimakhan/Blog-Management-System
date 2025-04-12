import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css','resources/js/app.js',
                'resources/js/blog.js',
                'resources/css/main.css',
                'resources/css/sidebar.css'],
            refresh: true,
        }),
        vue(),
        // tailwindcss(),
    ],

    build: {
        manifest: true,
        outDir: "public/build",
        // outDir: "public/assets/build",
    },
});
