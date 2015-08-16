var gulp = require('gulp');
var less = require('gulp-less');
var watchLess = require('gulp-watch-less');
var minifyCSS = require('gulp-minify-css');

/*
gulp.task('less', function() {  
  gulp.src('./assets/css/styles.less')
    .pipe(less())
    .pipe(minifyCSS({keepBreaks: false}))
    .pipe(gulp.dest('./assets/css/'));
});

gulp.task('watch', function() {
    gulp.watch('./assets/css/*.less', ['less']);  
});
*/

gulp.task('default', function () {
  gulp.src('./assets/css/styles.less')
    .pipe(less())
    .pipe(minifyCSS({keepBreaks: false}))
    .pipe(gulp.dest('./assets/css'))
});