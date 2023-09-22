import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [ 'resources/css/app.css', 'resources/js/app.ts' ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: '4000',
        hmr: {
            host: 'localhost',
        },
    },
});
