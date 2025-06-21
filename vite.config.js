<<<<<<< HEAD
import laravel from "laravel-vite-plugin";
import { defineConfig } from "vite";
=======
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
>>>>>>> refs/remotes/origin/main

export default defineConfig({
    plugins: [
        laravel({
<<<<<<< HEAD
            input: ["resources/css/app.css", "resources/js/app.js"],
=======
            input: ['resources/css/app.css', 'resources/js/app.js'],
>>>>>>> refs/remotes/origin/main
            refresh: true,
        }),
    ],
});
