var gulp = require('gulp'),
    plugins = require('gulp-load-plugins')();

gulp.task('sass', () => gulp
  .src('css/quis.scss')
  .pipe(plugins.sass({
    outputStyle: 'compressed'
  }))
  .pipe(gulp.dest('css/'))
);

gulp.task('js', () => gulp
  .src([
    'js/constants.js',
    'js/rateLimit.js',
    'js/scrollPages.js',
    'js/scrollPhotos.js',
    'js/jquery.infinitescroll.js',
    'js/jquery.viewportSelector.js',
    'js/map.js',
    'js/init.js',
  ])
  .pipe(plugins.uglify({
    outputStyle: 'compressed'
  }))
  .pipe(plugins.concat('quis.js'))
  .pipe(gulp.dest('js/'))
);

gulp.task('watchForChanges', function() {
  gulp.watch('js/**/*', ['js']);
  gulp.watch('css/**/*', ['sass']);
});

gulp.task('build',
  ['sass', 'js']
);

gulp.task('default',
  ['build', 'watchForChanges']
);
