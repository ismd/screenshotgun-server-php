var gulp = require('gulp'),
    environment = process.env.NODE_ENV || 'development';

var less = require('gulp-less'),
    concat = require('gulp-concat');

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
        './bower_components/html5-boilerplate/dist/css/main.css',
        './bower_components/html5-boilerplate/dist/css/normalize.css',
        './less/style.less'
    ];

    gulp.src(files)
        .pipe(less({
            plugins: 'production' == environment ? [autoprefix, cleancss] : [autoprefix]
        }))
        .pipe(concat('style.css'))
        .pipe(gulp.dest('./public/css'))
});

// JavaScript
//gulp.task('js', function() {
//    var jsFiles = [
//        'bower_components/jquery/dist/jquery.js',
//        'bower_components/angular/angular.js',
//        'bower_components/angular-route/angular-route.js',
//        'bower_components/bootstrap/dist/js/bootstrap.js',
//        'bower_components/bootstrap-select/dist/js/bootstrap-select.js',
//        'bower_components/Chart.js/Chart.js',
//        'bower_components/jquery-ui/jquery-ui.js',
//        'bower_components/jquery-ui/ui/i18n/datepicker-ru.js',
//        'bower_components/angular-ui-date/src/date.js',
//        'app/init.js',
//        'app/services/**/*.js',
//        'app/directives/**/*.js',
//        'app/controllers/**/*.js'
//    ];
//
//    var stream = gulp.src(jsFiles)
//        .pipe(concat('app.js'))
//        .pipe(chmod(666));
//
//    if ('production' == environment) {
//        stream = stream.pipe(uglify());
//    }
//
//    return stream.pipe(gulp.dest('../public/js'));
//});

// Watch
gulp.task('watch', function() {
    gulp.watch('./less/**/*.less', ['less']);
    //gulp.watch('app/**/*.js', ['js']);
});

var tasks = ['less'];

if ('development' == environment) {
    tasks.push('watch');
}

gulp.task('default', tasks);
