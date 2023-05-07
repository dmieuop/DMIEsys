import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import mkcert from 'vite-plugin-mkcert';

export default defineConfig({
    server: {
        https: true,
        host: 'dmiesys.test',
    },
    plugins: [
        mkcert(),
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
});
