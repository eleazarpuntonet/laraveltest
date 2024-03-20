import * as path from 'path'
import dts from "vite-plugin-dts";
import vue from '@vitejs/plugin-vue2'
import { checker } from 'vite-plugin-checker';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        vue(),
        dts({
            insertTypesEntry: true,
        }),
        checker({
            typescript: true,
            vueTsc: true,
        }),
    ],
    build: {
        cssCodeSplit: true,
        lib: {
            entry: "resources/js/main.ts",
            name: 'TemplateWizard',
            formats: ["es", "cjs", "umd"],
            fileName: format => `template-wizard.${format}.js`
        },
        rollupOptions: {
            // make sure to externalize deps that should not be bundled
            // into your library
            input: {
                main: path.resolve(__dirname, "resources/js/main.ts")
            },
            external: ['vue', 'axios', 'mdb4-vue'],
            output: {
                assetFileNames: (assetInfo) => {
                    return assetInfo.name === 'main.css'
                        ? 'template-wizard.css'
                        : assetInfo.name!;
                },
                exports: "named",
                globals: {
                    'vue': 'Vue',
                    'axios': 'axios',
                    'mdb4-vue': 'mdb4-vue',
                },
            },
        },
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
});
