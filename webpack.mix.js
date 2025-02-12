const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.copyDirectory("resources/images", "public/images");

mix.js('resources/js/app.js', 'public/js')
    .copy(
        'node_modules/@fortawesome/fontawesome-free/webfonts',
        'public/webfonts'
    )
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);

// mix.copy('resources/css/card/fonts/*', 'public/css/card/fonts');
mix.sass('resources/sass/app.scss', 'public/css')
