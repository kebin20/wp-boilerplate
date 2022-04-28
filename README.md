# WP Boilerplate

-   This is my custom Wordpress boilerplate for creating custom Wordpress themes
-   This boilerplate uses BEM + ITCSS (BEMIT) to help eliminate namespacing issues
-   All assets in `/src/` are processed through Webpack and unloaded into `/dist/`
-   The use-case for this template is for a Japanese client

## Features

Webpack

-   PostCSS
    -   SASS parsing
    -   Style linting
    -   Autoprefixing
    -   Inlining CSS `url()` assets
-   Browsersync
    -   Reloads PHP/JS files on change
-   Sourcemaps

WP Plugins supported by default

-   ACF (with 2 option pages)
-   Contact Form 7

Files queued by default

-   Bundled CSS
-   Bundled JS (including vendor JS/CSS assets)

## Launching:

Working versions:

-   Node: v17.2.0
-   NPM: v8.1.4
-   Webpack: 5.72.0

Commands:

-   `npm run build`
    -   Builds all assets and also runs `postbuild` script, converting JPG to WEBP and cleaning
-   `npm run dev`
    -   Launches dev environment
-   `npm run clean`
    -   Removes build files
-   `npm run unpack`
    -   Cleans, installs `node_modules` and WP plugins through Composer, runs build script

## Bugs:

-   StyleLint
    -   _stylelint-disable-line_ feature is broken
    -   _ignoreFiles_ option in .stylelintrc is broken
