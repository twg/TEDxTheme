var gulp = require('gulp'),
    sass = require('gulp-sass'),
    livereload = require('gulp-livereload'),
    tinylr = require('tiny-lr'),
    autoprefixer = require('gulp-autoprefixer'),
    rename = require('gulp-rename'),
    notify = require('gulp-notify'),
    minifycss = require('gulp-minify-css'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    clean = require('gulp-clean'),
    order = require('gulp-order'),
    concat = require('gulp-concat');


//-- Bower Dependencies -----------------------------------------------------
var bowerJsDependencies = [
  './vendor/jquery/dist/jquery.js',
  './vendor/bootstrap/dist/js/bootstrap.js',
  './vendor/angular/angular.js'
];
var bowerCssDependencies = [
  './vendor/bootstrap/dist/css/bootstrap.css',
  './vendor/font-awesome/css/font-awesome.css',
  './vendor/animate.css/animate.css'
];

//-- Compile SCSS -----------------------------------------------------------
gulp.task('styles', function() {
  return gulp.src('./assets/scss/**/*.scss')
    .pipe(sass({style: 'expand', errLogToConsole: true}))
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(gulp.dest('./dist/css'))
    .pipe(rename({suffix: '.min'}))
    .pipe(minifycss())
    .pipe(gulp.dest('./dist/css'));
});


//-- Compile Javascripts ----------------------------------------------------
gulp.task('scripts', function() {
  return gulp.src('./assets/js/**/*.js')
    .pipe(order([
      'application.js',
      '*.js'
    ]))
    .pipe(jshint('.jshintrc'))
    .pipe(jshint.reporter('default'))
    .pipe(concat('application.js'))
    .pipe(gulp.dest('dist/js'))
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify())
    .pipe(gulp.dest('dist/js/'));
});


//-- Merge and Minify Bower JS Dependencies ------------------------------------
gulp.task('vendor-js', function() {
  return gulp.src(bowerJsDependencies)
    .pipe(concat('vendor.js'))
    .pipe(gulp.dest('./dist/js'))
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify())
    .pipe(gulp.dest('dist/js'));
});


//-- Merge and Minify Bower CSS Dependencies --------------------------------
gulp.task('vendor-css', function() {
  return gulp.src(bowerCssDependencies)
    .pipe(concat('vendor.css'))
    .pipe(gulp.dest('./dist/css'))
    .pipe(rename({suffix: '.min'}))
    .pipe(minifycss())
    .pipe(gulp.dest('dist/css'));
});


//-- Copy Images to the Dist Directory --------------------------------------
gulp.task('images', function() {
  return gulp.src('./assets/img/**/*')
    .pipe(gulp.dest('./dist/img'));
});


//-- Copy Fonts to the Dist Directory ---------------------------------------
gulp.task('fonts', function() {
  return gulp.src('./vendor/font-awesome/fonts/**/*.*')
    .pipe(gulp.dest('./dist/fonts'));
});


//-- Clean task to run before deploys ---------------------------------------
gulp.task('clean', function() {
  return gulp.src(['./dist/assets/css', './dist/assets/js'], {read: false})
    .pipe(clean());
});


//-- Default Task -----------------------------------------------------------
gulp.task('default', function() {
  gulp.start('styles', 'scripts', 'vendor-css', 'vendor-js', 'images', 'fonts', 'watch');
});


//-- Watching & Livereload --------------------------------------------------
gulp.task('watch', function() {

  gulp.watch('./assets/scss/**/*.scss', ['styles']);
  gulp.watch('./assets/js/**/*.js', ['scripts']);
  gulp.watch('./assets/img/**/*', ['images']);

  livereload.listen();
  gulp.watch(['./dist/**', './**/*.php']).on('change', livereload.changed);

});