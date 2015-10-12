var gulp = require('gulp');
var del = require('del');
var bs = require('browser-sync');
var plugins = require('gulp-load-plugins')();
var sourcemaps = require('gulp-sourcemaps');
var ui = require('helpful-ui');
var bower = require('bower-files')();
var dist = './theme';
var port = 8029;

/**
 * CLEAN
 * Various clean tasks that remove un-needed code from each build.
 */
gulp.task('clean:styles', function (done) {
  del([dist + '/css/*.css']).then(function () {
    done();
  });
});

/**
 * STYLES:BOWER
 * Compiles all Bower loaded Javascript into a single vendor.js file.
 */
gulp.task('styles:bower', function () {
  return gulp
    .src(bower.ext('css').files)
    .pipe(plugins.concat('vendor.css'))
    // .pipe(gulp.dest(dist + '/css'))
    .pipe(plugins.minifyCss())
    .pipe(plugins.rename({ suffix: '.min' }))
    .pipe(gulp.dest(dist + '/css'))
});

/**
 * STYLES:COMPILE
 * Compile Stylus files, apply vendor prefixes and minify stylesheets.
 */
gulp.task('styles', ['clean:styles'], function () {
  return gulp
    .src('./stylus/*.styl')
    .pipe(plugins.plumber())
    .pipe(sourcemaps.init())
      .pipe(plugins.stylus({ use: [ui()] }))
      .pipe(plugins.autoprefixer())
      // .pipe(gulp.dest(dist + '/css'))
      .pipe(bs.stream())
      .pipe(plugins.rename({ suffix: '.min' }))
      .pipe(plugins.minifyCss())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(dist + '/css'));
});

/**
 * SCRIPTS:BOWER
 * Compiles all Bower loaded Javascript into a single vendor.js file.
 */
gulp.task('scripts:bower', function () {
  return gulp
    .src(bower.ext('js').files)
    .pipe(plugins.concat('vendor.js'))
    // .pipe(gulp.dest(dist + '/js'))
    .pipe(plugins.uglify())
    .pipe(plugins.rename({ suffix: '.min' }))
    .pipe(gulp.dest(dist + '/js'))
});

/**
 * SCRIPTS:COMPILE
 * Compiles scripts into a single concatenated scripts file.
 */
gulp.task('scripts', function () {
  return gulp
    .src('./scripts/**/*.js')
    .pipe(sourcemaps.init())
      .pipe(plugins.concat('main.js'))
      // .pipe(gulp.dest(dist + '/js'))
      .pipe(plugins.uglify())
      .pipe(plugins.rename({ suffix: '.min' }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(dist + '/js'));
});

/**
 * BUILD
 * Run all compilation tasks.
 */
gulp.task('build', ['styles', 'styles:bower', 'scripts', 'scripts:bower']);

/**
 * WATCH
 * Automatically run tasks on file change.
 */
gulp.task('watch', ['build'], function () {
  gulp.watch('./**/*.styl', ['styles']).on('change', bs.reload);
  gulp.watch('./**/*.{html,php}', []).on('change', bs.reload);
});

/**
 * SERVER
 * Start a browser sync server for the project.
 */
gulp.task('serve', ['watch'], function () {
  plugins.connectPhp.server({ port: port }, function () {
    bs.init({
      proxy: 'localhost:' + port
    });
  });
});

/**
 * DEFAULT TASK
 */
gulp.task('default', ['watch']);
