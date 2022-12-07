# WP Boilerplate

This is my custom Wordpress boilerplate for creating bespoke Wordpress themes.
It provides basic support for features I commonly use on my websites. Including things like a contact form, customiseable content, a hamburger menu etc.

- Uses BEM + ITCSS (BEMIT) to help eliminate namespacing issues
- All assets in `/src/` are processed through Webpack and output into `/dist/`
- The default language for this template is Japanese

## Features

**Layout/Wordpress features**

- Secondary page header with breadcrumbs and fallback/404 image
- Post archive with pagination and fallback images for items
- One custom post type (CPT) – called 'Blog' (ブログ in Japanese)
- Fully accessible hamburger menu (mobile only)
- 404 page

**Wordpress Plugins supported (_required_):**

- Contact Form 7 (WPCF7):

  - For the contact form
  - Anti-spam built in for Japanese sites
  - Styles for WPCF7 bundled in with `style.css`

- ACF

  - Provides customiseability of the hero slider, social media links etc.
  - Stored as JSON to provide sync feature

- Yoast SEO

  - Used for Breacrumbs

**Files queued by Wordpress:**

- `style.css` (bundled CSS)
- `dist/index.js` (bundled JS – including vendor JS/CSS assets for _AOS_ and _Swiper_)

**Bundling:**

- Webpack
  - PostCSS
    - Tailwind
    - Autoprefixing
    - Inlining CSS `url()` assets
  - Browsersync
    - Reloads PHP/JS files on change
  - Sourcemaps
- Post-build script (`webpack-post.js`) minimizes JPG/PNG from `src/img` into `dist/img`

## Launching:

Working versions:

- Node: v17.2.0
- NPM: v8.1.4
- Webpack: 5.72.0

Commands:

- `npm run build`
  - Builds all assets and also runs `postbuild` script, converting JPG to WEBP and cleaning
- `npm run dev`
  - Launches dev environment
- `npm run clean`
  - Removes build files
- `npm run unpack`
  - Cleans, installs `node_modules` and WP plugins through Composer, runs build script

## Known bugs:
