var gulp = require('gulp');
var less = require('gulp-less');
var sourcemap = require('gulp-sourcemaps');
var minifyCSS = require('gulp-minify-css');

var files = {
    less: {
        glob: __dirname + '/less/**/*.less',
        main: __dirname + '/less/iasw.less',
        out: __dirname + '/public/css'
    }
};

var buildLess = function(cb) {
    gulp.src(files.less.main)
    .pipe(sourcemap.init())
    .pipe(less())
    .on('error', function(err) {
        console.log(err.message);
    })
    .pipe(minifyCSS())
    .pipe(sourcemap.write('./'))
    .pipe(gulp.dest(files.less.out))
    .on('error', function(err) {
        console.log(err.message);
    })
    .on('end', function() {
        console.log('LESS compiled to CSS');

        if (typeof cb === 'function') {
            return cb();
        }
    });
}

gulp.task('watch:less', function() {
    buildLess();

    gulp.watch(files.less.glob, function() {
        buildLess();
    });
});
