import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/progressbar/progress.css',
                'resources/js/Progressbar/progress.js',

                //sb admin template css
                'resources/sbadmin/vendor/fontawesome-free/css/all.min.css',
                'resources/sbadmin/css/sb-admin-2.min.css',
                //sb admin template js
                'resources/sbadmin/vendor/jquery/jquery.min.js',
                'resources/sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js',
                'resources/sbadmin/vendor/jquery-easing/jquery.easing.min.js',
                'resources/sbadmin/js/sb-admin-2.min.js'
                
            ],
            refresh: true,
        }),
    ],
});
