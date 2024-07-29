import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            // Este alias pode ser removido, a menos que você tenha uma razão específica para usá-lo
            // Vue já é importado como um módulo ESM por padrão
            // vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
