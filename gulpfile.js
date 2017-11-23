/* File: gulpfile.js */

// Grab our packages
var gulp = require('gulp'),
	plugins = require('gulp-load-plugins')();

// Define the default task and add the watch task to it
gulp.task('default', ['watch']);

// Define build task

// Configure watch task
gulp.task('watch', ['sass' /*, 'js'*/ ], function() {
	gulp.watch('resources/assets/sass/*.scss', ['sass']);
	// gulp.watch('public/js/*.js', ['js']);
});

// Configure sass task
gulp.task('sass', function() {
	gulp.src(['resources/assets/sass/app.scss', 'resources/assets/sass/admin.scss'] /*cfg.src + 'css/*.scss'*/ )
		// .pipe(plugins.sourcemaps.init())
		.pipe(plugins.sass({ errLogToConsole: true, outputStyle: 'compressed' }).on('error', plugins.sass.logError))
		// .pipe(plugins.sass({ errLogToConsole: true, outputStyle: 'expanded' }).on('error', plugins.sass.logError))
		.pipe(plugins.autoprefixer())
		// .pipe(plugins.sourcemaps.write())
		.pipe(gulp.dest('public/css'));
});

// Configure js task
gulp.task('js', function() {
	return gulp.src([
        'public/bower_components/jquery/dist/jquery.js',
        // 'public/bower_components/bootstrap-sass/assets/javascripts/bootstrap/modal.js',
        'public/bower_components/bootstrap-validator/dist/validator.js',
        'public/js/utils.js',
        'public/js/app.js'
      ])
		.pipe(plugins.concat('bundle.js'))
		.pipe(plugins.uglify())
		.pipe(gulp.dest('public/js'));
});
