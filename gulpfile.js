// Require our dependencies
//const babel = require("gulp-babel");
const gulp = require("gulp");
const concat = require("gulp-concat");
const uglify = require("gulp-uglify");
const imagemin = require("gulp-imagemin");
const del = require("del");
const clean = require("gulp-clean");
const rename = require("gulp-rename");
const browserSync = require("browser-sync").create();
const cssnano = require("gulp-cssnano");


var paths = {
    assets: "assets/",
    home: "wc-bom.php",
    lib_js: "assets/lib/scripts/",
    lib_css: "assets/lib/styles/",
    lib_img: "assets/lib/images/*",
    dist: "assets/dist/",
    dist_js: "assets/dist/scripts/",
    dist_css: "assets/dist/styles/",
    dist_img: "assets/dist/images/",
    includes: "includes/",
    classes: "classes/"
};

// Not all tasks need to use streams
// A gulpfile is just another node program and you can use any package available on npm
gulp.task("purge", function () {
    gulp.src(paths.dist_img + "*")
        .pipe(clean());
    gulp.src(paths.dist_js + "*")
        .pipe(clean());
    gulp.src(paths.dist_css + "*")
        .pipe(clean());
});

// Copy all static images
gulp.task("imagemin", function () {
    gulp.src(paths.lib_img)
    // Pass in options to the task
        .pipe(imagemin())
        .pipe(gulp.dest(paths.dist_img));
    gulp.src(paths.dist_img + "images")
        .pipe(clean());
});

gulp.task("cssnano", function () {
    gulp.src(paths.lib_css + "*.css")
        .pipe(cssnano())
        .pipe(rename({suffix: ".min"}))
        .pipe(gulp.dest(paths.dist_css))
});
/**
 * Minify compiled JavaScript.
 *
 * https://www.npmjs.com/package/gulp-uglify
 */
gulp.task("uglify", function () {

    gulp.src(paths.lib_js + "*.js")
        .pipe(uglify())
        .pipe(rename({suffix: ".min"}))
        .pipe(gulp.dest(paths.dist_js));
});


// Static Server + watching scss/html files
gulp.task("serve", function () {

    browserSync.init({
        proxy: "http://www.devnet.dev/wp-admin/"
    });

});

// Rerun the task when a file changes
gulp.task("watch", function () {
    //gulp.watch(paths.scripts, ["scripts"]);
    gulp.watch(paths.home).on("change", browserSync.reload);
    gulp.watch(paths.classes).on("change", browserSync.reload);
    gulp.watch(paths.includes).on("change", browserSync.reload);
});

gulp.task("default", ["purge", "imagemin", "cssnano", "uglify", "serve", "watch"]);
gulp.task("clean", ["purge", "imagemin", "cssnano", "uglify"]);
gulp.task("live", ["serve", "watch"]);
