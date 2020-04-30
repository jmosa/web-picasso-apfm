/**
 * Gulpfile.
 *
 * @author GGarcia;
 * @version 1.0.0;
 */

// Plugin Optimization

// Plugin Name

var pluginName = 'apfm-lighthouse-cpt';

// Admin CSS & JS
var cssAdminSrc = './src/admin/css/*.css'; // Source admin CSS folder.
var cssAdminDest = './admin/css/'; // Destination to minimized Admin CSS file.
var jsAdminSrc = './src/admin/js/*.js'; // Source admin JS folder.
var jsAdminDest = './admin/js/'; // Destination to minimized Admin JS file.

// Public CSS & JS
var cssPublicSrc = './src/public/css/*.css'; // Source public CSS folder.
var cssPublicDest = './public/css/'; // Destination to minimized public CSS file.
var jsPublicSrc = './src/public/js/*.js'; // Source public JS folder.
var jsPublicDest = './public/js/'; // Destination to minimized public JS file.

// Watch files
var cssAdminWatch = './src/admin/css/*.css'; // Watch admin CSS folder
var jsAdminWatch = './src/admin/js/*.js'; // Watch admin JS folder.
var cssPublicWatch = './src/public/css/*.css'; // Watch public CSS folder.
var jsPublicWatch = './src/public/js/*.js'; // Watch public JS folder.

/**
 * Load Plugins.
 *
 * Load gulp plugins and passing them semantic names.
 */

var gulp = require('gulp'); // Gulp of-course

// CSS related plugins.
var minifycss = require('gulp-uglifycss'); // Minifies CSS files.
var autoprefixer = require('gulp-autoprefixer'); // Autoprefixing magic.
var mmq = require('gulp-merge-media-queries'); // Combine matching media queries into one media query definition.

// JS related plugins.
var concat = require('gulp-concat'); // Concatenates JS files
var terser = require('gulp-terser'); // Minifies JS files

// Utility related plugins.
var rename = require('gulp-rename'); // Renames files E.g. style.css -> style.min.css
var lineec = require('gulp-line-ending-corrector'); // Consistent Line Endings for non UNIX systems. Gulp Plugin for Line Ending Corrector (A utility that makes sure your files have consistent line endings)
var filter = require('gulp-filter'); // Enables you to work on a subset of the original files by filtering them using globbing.
var sourcemaps = require('gulp-sourcemaps'); // Maps code in a compressed file (E.g. style.css) back to it’s original position in a source file (E.g. structure.scss, which was later combined with other css files to generate style.css)
var plumber = require('gulp-plumber'); // Logs notification on error


// Optimize Admin CSS Styles

gulp.task('cssAdmin', function() {
    return gulp.src(cssAdminSrc)
        .pipe(concat(pluginName + '-admin.min.css'))
        .pipe(minifycss({ maxLineLen: 0, uglyComments: true }))
        .pipe(gulp.dest(cssAdminDest));
});

// Optimize Public CSS Styles

gulp.task('cssPublic', function () {
    return gulp.src(cssPublicSrc)
        .pipe(concat(pluginName + '-public.min.css'))
        .pipe(minifycss({
            maxLineLen: 0,
            uglyComments: true
        }))
        .pipe(gulp.dest(cssPublicDest));
});

// Optimize Admin JS Script

gulp.task('jsAdmin', function() {
    return gulp.src(jsAdminSrc)
        .pipe(concat(pluginName + '-admin.min.js'))
        .pipe(terser())
        .pipe(lineec()) // Consistent Line Endings for non UNIX systems.
        .pipe(gulp.dest(jsAdminDest));
});

// Optimize Public JS Script

gulp.task('jsPublic', function () {
    return gulp.src(jsPublicSrc)
        .pipe(concat(pluginName + '-public.min.js'))
        .pipe(terser({
            ecma: 6, // specify one of: 5, 6, 7 or 8
            warnings: true,
        }))
        .pipe(lineec()) // Consistent Line Endings for non UNIX systems.
        .pipe(gulp.dest(jsPublicDest));
});

/**
 * Watch Tasks.
 *
 * Watches for file changes and runs specific tasks.
 */
gulp.task('default', gulp.series('cssAdmin', 'cssPublic', 'jsAdmin', 'jsPublic', function() {
    gulp.watch(cssAdminWatch, gulp.series('cssAdmin')); // Reload on file changes.
    gulp.watch(jsAdminWatch, gulp.series('jsAdmin')); // Reload on file changes.
    gulp.watch(cssPublicWatch, gulp.series('cssPublic')); // Reload on file changes.
    gulp.watch(jsPublicWatch, gulp.series('jsPublic')); // Reload on file changes.
}));
