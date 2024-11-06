import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue2'
import eslint from 'vite-plugin-eslint'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/filament/admin/theme.css',
        'resources/sass/app.scss',
        'resources/js/app.js',
      ],
      refresh: true,
    }),
    vue(),
    eslint({
      fix: true
    })
  ]
});
