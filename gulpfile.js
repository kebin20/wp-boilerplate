/**
 * Theme Name: Boilerplate
 * Author: Sean Verity
 * Notes: REQUIRES GULP 4
 */

const { src, dest, watch, series, parallel } = require("gulp");
const rename = require("gulp-rename");
const browsersync = require("browser-sync").create();
const sass = require("gulp-sass");
const autoprefixer = require("gulp-autoprefixer");
const plumber = require("gulp-plumber");
const sasslint = require("gulp-sass-lint");
const babel = require("gulp-babel");
const cache = require("gulp-cached");
const notify = require("gulp-notify");
const beeper = require("beeper");

/**
 * Watch Styles – Lint and trigger buildStyles()
 */
function watchStyles() {
    watch(
        ["scss/*.scss", "scss/**/*.scss"],
        { events: "all", ignoreInitial: false },
        series(sassLint, buildStyles)
    );
}

/**
 * Compile CSS from Sass
 */
function buildStyles() {
    return src("scss/style.scss")
        .pipe(plumbError()) // Global error handler through all pipes.
        .pipe(sass({ outputStyle: "expanded", indentWidth: 4 })) //Expanded for dev.
        .pipe(autoprefixer({ grid: "autoplace" }))
        .pipe(dest("js/ie"))
        .pipe(browsersync.reload({ stream: true }));
}

/**
 * Refresh page on index.js change
 */
function watchBabel() {
    return watch(
        ["js/index.js"],
        { events: "all", ignoreInitial: true },
        series(buildBabel)
    );
}

/**
 * Compile index.js with Babel
 */
 function buildBabel() {
    return src(["js/*.js", "!js/*.ie.js"])
    .pipe(
        babel({
            presets: ["@babel/preset-env"],
        })
    )
    .pipe(rename({ suffix: ".ie" }))
    .pipe(dest("js"))
    .pipe(browsersync.reload({ stream: true }));
}

/**
 * Refresh page on JS change
 */
function watchJS() {
    return watch(
        ["*.js", "**/*.js", "!js/index.js"], // Watching everything but index.js
        { events: "all", ignoreInitial: true },
        function (done) {
            browsersync.reload();
            done();
        }
    );
}

/**
 * Refresh page on PHP change
 */
function watchPHP() {
    return watch(
        ["*.php", "**/*.php"],
        { events: "all", ignoreInitial: true },
        function (done) {
            browsersync.reload();
            done();
        }
    );
}

/**
 * BrowserSync
 */
function browserSync(done) {
    browsersync.init({
        proxy: "localhost:3000/boilerplate-wp/", // Change this value to match your local URL.
        browser: "google chrome",
        open: "external",
        // host : '192.168.3.254' // In case of static IP
    });
    done();
}

/**
 * Lint SASS
 */
function sassLint() {
    return src(["scss/*.scss", "scss/**/*.scss"])
        .pipe(cache("sasslint"))
        .pipe(
            sasslint({
                configFile: ".sass-lint.yml",
            })
        )
        .pipe(sasslint.format());
    //.pipe(sasslint.failOnError()); //no failure on SASS Linting error
}

/**
 * Handle Errors
 */
function plumbError() {
    return plumber({
        errorHandler: function (err) {
            notify.onError({
                templateOptions: {
                    date: new Date(),
                },
                title: "Gulp error in " + err.plugin,
                message: err.formatted,
            })(err);
            beeper();
            this.emit("end");
        },
    });
}

/**
 * Export commands
 */

// $ gulp
exports.default = series(
    browserSync,
    parallel(watchStyles, watchPHP, watchJS, watchBabel)
);

// $ gulp watch
exports.watch = series(
    browserSync,
    parallel(watchStyles, watchPHP, watchJS, watchBabel)
);

// $ gulp build
exports.build = series(buildStyles, buildBabel);
