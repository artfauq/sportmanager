var gulp = require('gulp');
var gutil = require('gulp-util');

var clean = require('gulp-clean');
var filter = require('gulp-filter');

var bases = {
  app: 'app/',
  dist: 'dist/',
  lib: 'lib/',
  copy: ['**', '!*.htaccess', '!app/*.htaccess', '!app/webroot/*.htaccess', '!app/Config/database.php', '!index.php']
};

var paths = {
  webroot: 'app/webroot/',
  scripts: ['js/**/*.js'],
  styles: ['css/*.css'],
  php: ['*.php'],
  images: ['img/**/*.*'],
  fonts: ['fonts/*.*'],
  files: ['files/**/*'],
  others: ['.htaccess', 'favicon.ico']
};

gulp.task('clean', function() {
  return gulp.src(bases.copy, { cwd: bases.dist, read: false })
    .pipe(clean());
});

gulp.task('copy', ['clean'], function() {

  gulp.src(['index.php'])
    .pipe(gulp.dest(bases.dist));

  gulp.src([bases.app + '**/*', bases.ignore.toString()])
    .pipe(gulp.dest(bases.dist + 'app/'));

  gulp.src(bases.lib + '**/*')
    .pipe(gulp.dest(bases.dist + 'lib/'));

});

gulp.task('css', function() {
  return gulp.src(paths.styles, { cwd: bases.dist + webroot })
    .pipe(csscomb())
    .pipe(cssbeautify({ indent: '  ' }))
    .pipe(autoprefixer())
    .pipe(gulp.dest(bases.dist + webroot + 'css/'))
    .pipe(csso())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest(bases.dist + webroot + 'css/'));
});

gulp.task('js', function() {
  return gulp.src(paths.scripts, { cwd: bases.dist + webroot })
    .pipe(concat('main.js'))
    .pipe(jshint())
    .pipe(jshint.reporter('default'))
    .pipe(gulp.dest(bases.dist + webroot + 'js/'))
    .pipe(filesize())
    .pipe(uglify())
    .pipe(rename('main.min.js'))
    .pipe(gulp.dest(bases.dist + webroot + 'js/'))
    .pipe(filesize())
    .on('error', gutil.log);
});

gulp.task('img', function() {
  return gulp.src(paths.images, { cwd: bases.dist + webroot })
    .pipe(imagemin())
    .pipe(gulp.dest(bases.dist + webroot + 'img/'))
});
