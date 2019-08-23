const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.styles([
    'public/asset/styles/shards-dashboards.1.1.0.min.css',
    'public/asset/styles/extras.1.1.0.min.css'
], 'public/css/all.css');

mix.scripts([
    'public/asset/scripts/Chart.min.js',
    'public/asset/scripts/app/shards.min.js',
    'public/asset/scripts/app/jquery.sharrre.min.js',
    'public/asset/scripts/extras.1.1.0.min.js',
    'public/asset/scripts/shards-dashboards.1.1.0.min.js',
    'public/asset/scripts/app/app-ecommerce.1.3.1.min.js'
], 'public/js/all.js');
