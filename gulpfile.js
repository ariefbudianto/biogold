var elixir = require('laravel-elixir');

var paths = {
    'jquery': './vendor/bower_components/jquery/',
    'bootstrap': './vendor/bower_components/bootstrap-sass-superhero/assets/'
}

elixir(function(mix) {
    mix.sass('app.scss','public/css/styles.css')
        .copy(paths.bootstrap + 'fonts/bootstrap/**', 'public/fonts')
        .scripts([
            paths.jquery + "dist/jquery.js",
            paths.bootstrap + "javascripts/bootstrap.js"
        ], 'public/js/app.js');
});


