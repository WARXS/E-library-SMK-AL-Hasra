import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/design-tokens.css',
                'resources/css/auth-catalog.css',
                'resources/js/app.js',
                'resources/js/theme.js',
                'resources/js/auth-catalog.js',
            ],
            refresh: true,
        }),
    ],
});
