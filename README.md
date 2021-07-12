# WP Boilerplate

-   This is my custom Wordpress boilerplate for creating custom Wordpress themes.
-   This boilerplate uses BEMIT to help eliminate namespacing issues
    -   BEMIT = BEM + [ITCSS](www.creativebloq.com/web-design/manage-large-css-projects-itcss-101517528)

## Features

Features provided by Gulp

-   Autoprefixing
-   SASS parsing
-   SASS linting
-   Babel-fying index.js -> index-ie.js
    -   index-ie.js is then only loaded by IE users
-   Watching of all files and automatic updating through Browsersync
-   Live error alerts

WP Plugins supported by default

-   ACF (with 2 option pages)
-   Contact Form 7

Files queued by default

-   Default WP jQuery
-   Slick Slider
-   Lightbox
-   FontAwesome (Webfonts & CSS - no JS)
-   Animate-on-scroll (AOS)
-   IE polyfills
    -   Classlist API polyfill
    -   CSS Vars ponyfill
    -   Nodelist.forEach polyfill
    -   Object Fit polyfill

## To get started

Due to requirements of NodeSass boilerplate requires Node version 14.15.
Use NVM to manage versions.

```
$ nvm use 14.15
$ npm install
$ gulp watch
```
