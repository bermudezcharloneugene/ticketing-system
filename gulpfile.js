'use strict';
let gulp = require('gulp');
let sass = require('gulp-sass');
// let concat = require('gulp-concat');
sass.compiler = require('node-sass');

gulp.task('sass', function () {
   return gulp.src('public/scss/**/*.scss')

   .pipe(sass().on('error', sass.logError))
   .pipe(gulp.dest('public/css'));
});