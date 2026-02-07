import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import eslint from 'vite-plugin-eslint';
import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import { resolve } from 'path';
import { fileURLToPath } from 'url';

const __dirname = fileURLToPath(new URL('.', import.meta.url));

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/filament/admin/theme.css',
        'resources/css/app.css',
        'resources/js/app.ts',
      ],
      refresh: true,
    }),
    vue({
      template: {
        compilerOptions: {
          isCustomElement: (tag) => tag.includes('-'),
        },
      },
    }),
    wayfinder()
  ],
  resolve: {
    alias: {
      '@': resolve(__dirname, 'resources/js'),
    },
    extensions: ['.js', '.ts', '.jsx', '.tsx', '.json', '.vue'],
  },
});
