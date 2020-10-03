let gulp = require('gulp'),
sass = require('gulp-sass'),
sourcemaps = require('gulp-sourcemaps'),
concat = require('gulp-concat'),
path = require('path'),
jshint = require('gulp-jshint'),
jsmin = require('gulp-js-minify'),
cleanCSS = require('gulp-clean-css'),
plumber = require('gulp-plumber'),
notify = require('gulp-notify'),
replace = require('gulp-replace'),
browserSync = require('browser-sync').create(),
json = require('json-file'),
themeName = json.read('./package.json').get('name'),
siteName = json.read('./package.json').get('siteName'),
local = json.read('./package.json').get('localhost'),
themeDir = '../' + themeName,
plumberErrorHandler = { errorHandler: notify.onError({

	title: 'Gulp',

	message: 'Error: <%= error.message %>',

	line: 'Line: <%= line %>'

})

};
sass.compiler = require('node-sass');

// Static server
gulp.task('browser-sync', function() {
	browserSync.init({
		proxy: {
			target: local + siteName,
			ws: true
		},
		browser: 'chrome',
		watch: true,
		https: true
	});
});

gulp.task('sass', function () {

	return gulp.src('./sass/style.scss')

	.pipe(sourcemaps.init( { loadMaps: true } ) )

	.pipe(plumber(plumberErrorHandler))

	.pipe(sass())

	.pipe(cleanCSS())

	.pipe(concat('style.css'))

	.pipe( replace( /@charset.*?;/, '' ) )
	
	.pipe(sourcemaps.write('./maps'))

	.pipe(gulp.dest('./'))
	
	.pipe(browserSync.stream())
	
	.pipe(notify({
		message: "✔︎ STYLES-CSS task complete",
		onLast: true
	}));
	
});

gulp.task('admin-sass', function () {

	return gulp.src('./sass/admin-styles.scss')

	.pipe(sourcemaps.init( { loadMaps: true } ) )

	.pipe(plumber(plumberErrorHandler))

	.pipe(sass())

	.pipe(cleanCSS())

	.pipe(concat('admin-styles.css'))

	.pipe( replace( /@charset.*?;/, '' ) )
	
	.pipe(sourcemaps.write('./maps'))

	.pipe(gulp.dest('./assets/css'))
	
	.pipe(browserSync.stream())
	
	.pipe(notify({
		message: "✔︎ ADMIN-STYLES-CSS task complete",
		onLast: true
	}));
	
});

gulp.task('woo-sass', function () {

	return gulp.src('./sass/woocommerce.scss')

	.pipe(sourcemaps.init( { loadMaps: true } ) )

	.pipe(plumber(plumberErrorHandler))

	.pipe(sass())

	.pipe(cleanCSS())

	.pipe(concat('woocommerce.css'))

	.pipe(sourcemaps.write('./maps'))

	.pipe(gulp.dest('./'))

	.pipe(browserSync.stream())

	.pipe(notify({
		message: "✔︎ WOOCOMMERCE-CSS task complete",
		onLast: true
	}));

});

gulp.task('js', function () {

	return gulp.src( ['./js/navigation.js', './js/skip-link-focus-fix.js', './js/wonkamizer-js.js'] )

	.pipe(sourcemaps.init( { loadMaps: true } ) )

	.pipe(concat(themeName + '.min.js'))

	.pipe(plumber(plumberErrorHandler))

	.pipe(jshint())

	.pipe(jshint.reporter('default'))

	.pipe(jshint.reporter('fail'))

	.pipe(jsmin())
	
	.pipe(sourcemaps.write('./maps'))

	.pipe(gulp.dest('./assets/js'))

	.pipe(browserSync.stream())

	.pipe(notify({ 
		message: "✔︎ JS task complete",
		onLast: true
	}));

});

gulp.task('js-grations', function () {

	return gulp.src( './js/wonkagrations.js' )

	.pipe(sourcemaps.init( { loadMaps: true } ) )

	.pipe(concat(themeName + '-head.min.js'))

	.pipe(plumber(plumberErrorHandler))

	.pipe(jshint())

	.pipe(jshint.reporter('default'))

	.pipe(jshint.reporter('fail'))
	
	.pipe(sourcemaps.write('./maps'))

	.pipe(gulp.dest('./assets/js'))

	.pipe(browserSync.stream())

	.pipe(notify({ 
		message: "✔︎ JS-Grations task complete",
		onLast: true
	}));

});

gulp.task('admin-js', function () {

	return gulp.src( ['./inc/js/admin-edit.js'] )
	
	.pipe(sourcemaps.init( { loadMaps: true } ) )

	.pipe(concat( 'admin-' + themeName + '.min.js' ))

	.pipe(plumber(plumberErrorHandler))

	.pipe(jshint())

	.pipe(jshint.reporter('default'))

	.pipe(jshint.reporter('fail'))

	.pipe(jsmin())
	
	.pipe(sourcemaps.write('./maps'))

	.pipe(gulp.dest('./assets/js'))

	.pipe(browserSync.stream())

	.pipe(notify({ 
		message: "✔︎ ADMIN-JS task complete",
		onLast: true
	}));

});

gulp.task('watch', function() {

	gulp.watch('**/sass/**/*.scss', gulp.series( gulp.parallel( 'sass', 'woo-sass', 'admin-sass' ) ) ).on( 'change', browserSync.reload );
	gulp.watch('**/*.php').on('change', browserSync.reload);
	gulp.watch(['./js/*.js', './inc/js/*.js'], gulp.series( gulp.parallel( 'js', 'admin-js', 'js-grations' ) ) ).on( 'change', browserSync.reload );

});

gulp.task( 'default', gulp.series( gulp.parallel( 'sass', 'woo-sass', 'admin-sass', 'js', 'admin-js', 'js-grations', 'watch', 'browser-sync' ) ) );