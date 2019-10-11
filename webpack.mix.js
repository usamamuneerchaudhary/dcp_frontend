var mix = require('laravel-mix');

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.jsx?$/,
                use: [
                    {
                        loader: 'babel-loader',
                        options: Config.babel()
                    }
                ]
            }
        ]
    }
});

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

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');
mix.combine([
    'resources/assets/js/libs/jquery-3.3.1.min.js',
    'resources/assets/js/libs/bootstrap.min.js',
    'resources/assets/js/libs/jquery.validate.min.js',
    'resources/assets/js/libs/material.min.js',
    'resources/assets/js/libs/material-dashboard.js',
    'resources/assets/js/pace.min.js',
    'resources/assets/js/libs/sweet_alert.min.js',
    'resources/assets/js/libs/Chart.min.js',
    //'resources/assets/js/libs/additional-methods.js',
    'resources/assets/js/libs/uniform.min.js',
    'resources/assets/js/libs/functions.js',
    'resources/assets/js/libs/main.js'


], 'public/js/all.js');