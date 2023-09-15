const mix = require('laravel-mix');
mix.setResourceRoot('./');
mix.js('client/js/main.js', 'dist/js/main.js');
mix.js('client/js/formfield.js', 'dist/js/formfield.js');
mix.sass('client/css/main.scss', 'dist/css/main.css');

mix.webpackConfig({
    devtool: "source-map"
});
