var gulp = require('gulp'),
    environment = process.env.NODE_ENV || 'development';

var less = require('gulp-less'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify');

var LessPluginCleanCSS = require('less-plugin-clean-css'),
    LessPluginAutoPrefix = require('less-plugin-autoprefix'),
    cleancss = new LessPluginCleanCSS({
        advanced: true
    }),
    autoprefix = new LessPluginAutoPrefix({
        browsers: ['last 2 versions']
    });

// Less
gulp.task('less', function () {
    var files = [
        './node_modules/html5-boilerplate/dist/css/main.css',
        './node_modules/html5-boilerplate/dist/css/normalize.css',
        './less/style.less'
    ];

    return gulp.src(files)
        .pipe(less({
            plugins: 'production' === environment ? [autoprefix, cleancss] : [autoprefix]
        }))
        .pipe(concat('style.css'))
        .pipe(gulp.dest('./public/css'));
});

// JavaScript
gulp.task('js', function() {
    var files = [
        'node_modules/jquery/dist/jquery.min.js',
        './js/**/*.js'
    ];

    var stream = gulp.src(files)
        .pipe(concat('app.js'));

    if ('production' === environment) {
        stream = stream.pipe(uglify());
    }

    return stream.pipe(gulp.dest('./public/js'));
});

// Watch
gulp.task('watch', function() {
    gulp.watch('./less/**/*.less', gulp.parallel('less'));
    gulp.watch('./js/**/*.js', gulp.parallel('js'));
});

var tasks = ['less', 'js'];

if ('development' === environment) {
    tasks.push('watch');
}

gulp.task('default', gulp.series(gulp.parallel(tasks)));
