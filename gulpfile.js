// Module to require whole directories
var requireDir = require('require-dir');

// Pulling in all tasks from the tasks folder
requireDir('./gulp-tasks', { recurse: true });

var gulp = require('gulp');
var browserSync = require('browser-sync');

////Available plugins
// var sass = require('gulp-sass');
// var uglify = require('gulp-uglifycss');
// var jshint = require('gulp-jshint');
// var minify = require('gulp-minify');
// var ts = require('gulp-typescript');
// var tslint = require("gulp-tslint");


const DEPLOYMENT_URL="wocker.dev";


/*
GENERAL TASKS
*/

//use browser sync for quick development
gulp.task('browser-sync', function () {
    browserSync.init({
        proxy: DEPLOYMENT_URL
    });
});

//track changes on all php files and reload browser sync
gulp.task('php-dev-watch', function () {
    //reload when themes and plugins php files changes    
    gulp.watch('./wp-content/themes/**/*.php').on('change', browserSync.reload);
    gulp.watch('./wp-content/plugins/**/*.php').on('change', browserSync.reload);
});

//dev tasks
//gulp.task('dev', ['wl-theme-sass-dev', 'wl-theme-sass-watch', 'browser-sync', 'php-dev-watch']);
gulp.task('dev', ['azulcaribe-theme-sass-dev', 'azulcaribe-theme-sass-watch', 'browser-sync', 'php-dev-watch']);

//production tasks
//gulp.task('default', ['wl-theme-sass']);
gulp.task('default', ['azulcaribe-theme-sass']);
