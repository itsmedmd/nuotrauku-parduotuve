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

// compile all files from "resources/css/" to "public/css"
function findFiles(dir) {
    const fs = require('fs');
    return fs.readdirSync(dir).filter(file => {
        return fs.statSync(`${dir}/${file}`).isFile();
    });
}

findFiles("resources/css").forEach((file) => {
    mix.postCss("resources/css/" + file, "public/css");
});

mix.js('resources/js/app.js', 'public/js');
