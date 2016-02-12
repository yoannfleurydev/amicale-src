/**
 * Created by valentin on 2/10/16.
 */
// Include plugins
var gulp      = require('gulp'),
    rename    = require('gulp-rename'),     // Renommage des fichiers
    postcss   = require('gulp-postcss'),       // Conversion des SCSS en CSS
    sass      = require('gulp-sass');

// Variables de chemins
var source = './bootstrap-sass-3.3.6'; // dossier de travail
var destination = 'web/css/'; // dossier à livrer

var preprocessor = [
    require('cssnano')({
        browsers: ['last 2 versions']
    })
];

gulp.task('css', function() {
gulp.src(source + '/sass/*.scss')    // Prend en entrée les fichiers *.scss
    .pipe(sass().on('error', sass.logError))                 // Compile les fichiers
    .pipe(postcss(preprocessor))                 // Minifie le CSS qui a été généré
    .pipe(gulp.dest(destination));
});

gulp.task('css:watch', function() {
   gulp.watch(source + '/**/*.scss', ['css']);
});