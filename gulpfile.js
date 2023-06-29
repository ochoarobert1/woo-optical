// Example of how to zip a directory 
var gulp = require('gulp');
var zip = require('gulp-zip');

gulp.task('zip', function () {
  return gulp.src([
    './**/*', 
    '!./{node_modules,node_modules/**/*}', 
    '!./{.less}', 
    '!./gulpfile.js', 
    '!./package.json', 
    '!./package-lock.json'
  ])
    .pipe(zip('woo-optical.zip'))
    .pipe(gulp.dest('./../'));
});