// START Editing Project Variables.
// Project related.
var project = "xxxWP"; // Project Name.
var projectURL = "localhost:85"; // Local project URL of your already running WordPress site. Could be something like local.dev or localhost:8888.
var productURL = "./"; // Theme/Plugin URL. Leave it like it is, since our gulpfile.js lives in the root folder.

var projectFolder =
  "./www/wp-content/themes/bootstrap-on-wordpress-theme-master-child";

var projectPHPWatchFiles = [
  "./www/wp-content/themes/bootstrap-on-wordpress-theme-master/**/*.php",
  projectFolder + "/**/*.php",
  projectFolder + "/assets/js/**/*.js",
  "./www/site/app/**/*.php",
  "./www/site/bootstrap/**/*.php",
  "./www/site/config/**/*.php",
  "./www/site/public/**/*.*",
  "./www/site/resources/**/*.php",
  "./www/site/routes/**/*.php"
];

process.title = "G: " + project;

// Browsers you care about for autoprefixing.
// Browserlist https        ://github.com/ai/browserslist
const AUTOPREFIXER_BROWSERS = [
  "last 2 version",
  "> 1%",
  "ie >= 9",
  "ie_mob >= 10",
  "ff >= 30",
  "chrome >= 34",
  "safari >= 7",
  "opera >= 23",
  "ios >= 7",
  "android >= 4",
  "bb >= 10"
];

// STOP Editing Project Variables.

var gulp = require("gulp"); // Gulp of-course
var autoprefixer = require("gulp-autoprefixer"); // Autoprefixing magic.
var rename = require("gulp-rename"); // Renames files E.g. style.css -> style.min.css
var lineec = require("gulp-line-ending-corrector"); // Consistent Line Endings for non UNIX systems. Gulp Plugin for Line Ending Corrector (A utility that makes sure your files have consistent line endings)
var sourcemaps = require("gulp-sourcemaps"); // Maps code in a compressed file (E.g. style.css) back to it’s original position in a source file (E.g. structure.scss, which was later combined with other css files to generate style.css)
var notify = require("gulp-notify"); // Sends message notification to you
var browserSync = require("browser-sync").create(); // Reloads browser and injects CSS. Time-saving synchronised browser testing.
var reload = browserSync.reload; // For manual browser reload.
var uglifycss = require("gulp-uglifycss"); //Gulp plugin to use UglifyCSS

/*------------------------------my vars------------------------------*/

var less = require("gulp-less");
var lesssourcemap = require("gulp-less-sourcemap");
var sourcemaps = require("gulp-sourcemaps");
var gutil = require("gulp-util");
var notifier = require("node-notifier");
var chalk = require("chalk");
var log = console.log;

var concat = require("gulp-concat");
var uglify = require("gulp-uglify");
var pump = require("pump");

var mylesssrc = projectFolder + "/assets/less/";
var mylessdest = projectFolder + "/assets/css/";
var mylessdest_wp = projectFolder + "/";

var mylessfilesWP = "css.wp.less"; //FOR WP
var mylessfilesEN = "css.bs3.en.less";

var css_wp1 = "blocks.css"; //FOR WP GUTENBERG
var css_wp2 = "editor-style.css"; //FOR WP TINY MCE CLASSIC

var css_en = "css.bs3.en.css";
var min_css_en = "css.bs3.en.min.css";

//FOR WP
var less_wp_backend = [mylesssrc + "compress.less", mylesssrc + "shared.less"];

//WATCH THESE FILES READY FOR TASK
var less_en = mylesssrc + "*.less";

gulp.task("browser-sync", function() {
  browserSync.init({
    proxy: projectURL,
    snippetOptions: { rule: { match: /$/ } },
    browser: "chrome",
    logLevel: "info", //debug
    logPrefix: project,
    open: false,
    injectChanges: true,
    reloadDelay: 500,
    files: [
      {
        match: projectPHPWatchFiles,
        fn: function(event, file) {
          this.reload();
        }
      }
    ],

    notify: {
      styles: {
        top: "auto",
        bottom: "0",
        margin: "0px",
        padding: "5px",
        position: "fixed",
        fontSize: "1em",
        zIndex: "9999",
        borderRadius: "5px 0px 0px",
        color: "white",
        textAlign: "center",
        display: "block",
        backgroundColor: "rgba(255, 0, 0, 0.8)"
      }
    }
  });

  log(chalk.white.bgCyan.bold("Start browserSync..."));
});

/*-----------------------js concat combine+sourcemap---------------------------*/

var myjssrc = [
  projectFolder + "/assets/js/resource/1.frontend.js",
  projectFolder + "/assets/js/resource/2.sticky.sidebar.js",
  projectFolder + "/assets/js/resource/5.jquery.fancybox.mousewheel.js",
  projectFolder + "/assets/js/resource/6.jquery.fancybox.js",
  projectFolder + "/assets/js/resource/7.fancybox.setup.js"
];

var myjsdest = projectFolder + "/assets/js/";
var jsoutput1 = "all.js"; /*THIS FILE WILL HUGE SIZE BECUASE SOUCEMAP*/
var jsoutput2 = "all.min.js";

gulp.task("javascript-combine", function() {
  //combine them
  return gulp
    .src(myjssrc)
    .pipe(sourcemaps.init())
    .pipe(concat(jsoutput1))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(myjsdest));
});

gulp.task("javascript-compress", function(cb) {
  //uglify+compress js
  var options = {
    //preserveComments: 'license',
  };
  pump(
    [
      gulp.src(myjsdest + jsoutput1),
      uglify(options),
      rename({ suffix: ".min" }),
      gulp.dest(myjsdest)
    ],
    cb
  );
});

/*------------------------------my functions------------------------------*/

gulp.task("compile-lessWP", function() {
  gulp
    .src(mylesssrc + mylessfilesWP)
    .pipe(less())
    .pipe(autoprefixer(AUTOPREFIXER_BROWSERS))
    .pipe(rename(css_wp1))
    .pipe(gulp.dest(mylessdest_wp))
    .pipe(rename(css_wp2))
    .pipe(gulp.dest(mylessdest_wp));
  log(chalk.white.bgGreen.bold("Compile WordPress CSS for backend!"));
});

gulp.task("compile-lessEN", function() {
  gulp
    .src(mylesssrc + mylessfilesEN)
    .pipe(less())
    .pipe(autoprefixer(AUTOPREFIXER_BROWSERS))
    .pipe(rename(css_en))
    .pipe(gulp.dest(mylessdest));
  log(chalk.white.bgYellow.bold("LESS CSS processed"));
});

gulp.task("compile-lesssourcemapEN", function() {
  setTimeout(function() {
    //delay them a bit...
    gulp
      .src(mylesssrc + mylessfilesEN)
      .pipe(
        lesssourcemap({
          sourceMap: {
            sourceMapRootpath: "../less", //Optional absolute or relative path to your LESS files
            sourceMapFileInline: false
          }
        })
      )
      .on("error", function(error) {
        gutil.log(gutil.colors.yellow(error.message));
        // Notify on error. Uses node-notifier
        notifier.notify({
          title: "Less error",
          time: 8000,
          message: error.message
        });
      })
      .pipe(gulp.dest(mylessdest));
    log(chalk.white.bgYellow.bold("Update sourcemap"));
  }, 1500);
});

gulp.task("cssinjectEN", function() {
  setTimeout(function() {
    gulp.src(mylessdest + css_en).pipe(browserSync.stream());
    log(chalk.white.bgYellow.bold("Inject CSS EN!"));
  }, 1000);
});

gulp.task("cssUglify", function() {
  gulp
    .src(mylessdest + css_en)
    .pipe(
      uglifycss({
        maxLineLen: 0,
        uglyComments: true
      })
    )
    .pipe(rename(min_css_en))
    .pipe(gulp.dest(mylessdest));
  log(chalk.white.bgYellow.bold("Uglify CSS done!"));
});

gulp.task("jsinject", function() {
  gulp.src(myjsdest + jsoutput2).pipe(browserSync.stream());
  log(chalk.white.bgRed.bold("Inject JS!"));
});

gulp.task("default", ["browser-sync"], function(done) {
  //LESS ONLY NO RELOAD
  gulp.watch(less_wp_backend, ["compile-lessWP"]);

  gulp.watch(less_en, ["compile-lessEN"]);
  gulp.watch(less_en, ["compile-lesssourcemapEN"]);
  gulp.watch(mylessdest + css_en, ["cssinjectEN"]);
  gulp.watch(mylessdest + css_en, ["cssUglify"]);

  //JS
  gulp.watch(myjssrc, ["javascript-combine"]);
  gulp.watch(myjsdest + jsoutput1, ["javascript-compress"]);
  gulp.watch(myjsdest + jsoutput2, ["jsinject"]);
});
