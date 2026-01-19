import { defineConfig } from "vite";
import laravel, { refreshPaths } from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/filament/user/theme.css",
                "vendor/livewire/livewire/dist/livewire.js"
            ],
            refresh: [...refreshPaths, "app/Livewire/**"],
        }),
    ],
});
