/******************************************************************
Bluecar theme tasks

Here are the gulp tasks to automatize transpiling of the theme files

******************************************************************/

var sass = require('gulp-sass');
var gulp = require('gulp');
var browserSync = require('browser-sync');
var uglify = require('gulp-uglifycss');


/**
    DEVELOPMENT
**/
gulp.task('wl-theme-sass-dev', function () {
    
    //transpile style.scss to css
    gulp.src('./wp-content/themes/bones4/library/scss/style.scss')
        .pipe(sass())
        .pipe(gulp.dest('./wp-content/themes/bones3/library/css')) //write in prod folder
        .pipe(browserSync.stream()); //sync with browserSync

    //transpile style.scss to css
    gulp.src('./wp-content/themes/bones3/library/scss/ie.scss')
        .pipe(sass())
        .pipe(gulp.dest('./wp-content/themes/bones3/library/css')) //write in prod folder
        .pipe(browserSync.stream()); //sync with browserSync

    //transpile style.scss to css
    gulp.src('./wp-content/themes/bones3/library/scss/login.scss')
        .pipe(sass())
        .pipe(gulp.dest('./wp-content/themes/bones3/library/css')) //write in prod folder
        .pipe(browserSync.stream()); //sync with browserSync

});

gulp.task('wl-theme-sass-watch', function () {

    //watch and transpile a theme files when they change
    gulp.watch('./wp-content/themes/bones3/library/scss/**/*.scss', ['wl-theme-sass-dev']);

});



/**
    PRODUCTION
**/

gulp.task('wl-theme-sass', function () {

    //transpile scss to sass
    gulp.src('./wp-content/themes/bones3/library/scss/style.scss')
        .pipe(sass())
        .pipe(uglify()) //minimize        
        .pipe(gulp.dest('./wp-content/themes/bones3/library/css')); //write in prod folder

    gulp.src('./wp-content/themes/bones3/library/scss/ie.scss')
        .pipe(sass())
        .pipe(uglify()) //minimize        
        .pipe(gulp.dest('./wp-content/themes/bones3/library/css')); //write in prod folder

    gulp.src('./wp-content/themes/bones3/library/scss/editor-style.scss')
        .pipe(sass())
        .pipe(uglify()) //minimize        
        .pipe(gulp.dest('./wp-content/themes/bones3/library/css')); //write in prod folder

    gulp.src('./wp-content/themes/bones3/library/scss/login.scss')
        .pipe(sass())
        .pipe(uglify()) //minimize        
        .pipe(gulp.dest('./wp-content/themes/bones3/library/css')); //write in prod folder
});