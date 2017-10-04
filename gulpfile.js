var gulp = require('gulp');
var sourceMaps = require('gulp-sourcemaps');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var imageMin = require('gulp-imagemin');
var cleanCss = require('gulp-clean-css');
var del = require('del');

var paths = {
    scripts: [
        'web/asset/js/common.js',
        'web/asset/js/admin.js',
        'web/asset/js/home.js',
        'web/asset/js/search.js'
    ],
    images: 'web/asset/images/**/*',
    css: 'web/asset/css/**/*'
};

// Not all tasks need to use stream
gulp.task('clean', function () {
    return del(['build']);
});

gulp.task('scripts', ['clean'], function () {
    return gulp.src(paths.scripts)
        .pipe(sourceMaps.init())
        .pipe(uglify())
        .pipe(concat('bundle.min.js'))
        .pipe(sourceMaps.write())
        .pipe(gulp.dest('web/build/js'));
});

gulp.task('css', ['clean'], function () {
    return gulp.src(paths.css)
        .pipe(cleanCss({compatibility: 'ie8'}))
        .pipe(concat('bundle.min.css'))
        .pipe(gulp.dest('web/build/css'));
});

gulp.task('images', ['clean'], function () {
    return gulp.src(paths.images)
        .pipe(imageMin({optimizationLevel: 5}))
        .pipe(gulp.dest('web/build/images'));
});

gulp.task('watch', function () {
    gulp.watch(paths.scripts, ['scripts']);
    gulp.watch(paths.css, ['css']);
    gulp.watch(paths.images, ['images']);
});

// The default task (called when you run `gulp` from cli)
gulp.task('default', ['scripts', 'images', 'css']);

