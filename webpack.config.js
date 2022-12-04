/**
 * Theme Name: Projectname
 * Author: Sean Verity
 */

import path from "path";
import { fileURLToPath } from "url";
const __dirname = path.dirname(fileURLToPath(import.meta.url));

/* Plugin Setup and options
----------------------------------------------- */
// Extract CSS files
import _MiniCssExtractPlugin from "mini-css-extract-plugin";
const MiniCssExtractPlugin = new _MiniCssExtractPlugin({
    filename: "../[name].css",
});

//BrowserSync
import _BrowserSyncPlugin from "browser-sync-webpack-plugin";
const BrowserSyncPlugin = new _BrowserSyncPlugin({
    browser: "google chrome",
    files: ["**/*.php", "src/js/*", "src/img/*"],
    host: "localhost",
    open: "external",
    port: 3000,
    proxy: "http://localhost:3000/projectname-wp/",
});

/* Export setup
----------------------------------------------- */
const entry = {
    "js/index": "./src/js/index",
    style: "./src/scss/style.scss",
};

const output = {
    filename: "[name].js",
    path: path.resolve(__dirname, "dist"),
};

const plugins = [MiniCssExtractPlugin, BrowserSyncPlugin];

export default {
    entry,
    output,
    plugins,
    stats: "minimal",
    devtool: "source-map",
    module: {
        rules: [
            { test: /\.css$/, use: ["style-loader", "css-loader"] },
            {
                test: /\.scss$/,
                use: [
                    _MiniCssExtractPlugin.loader,
                    "css-loader",
                    {
                        loader: "postcss-loader",
                        options: {
                            sourceMap: true,
                            postcssOptions: {
                                plugins: [
                                    "postcss-assets",
                                    ["tailwindcss", {}],
                                    "autoprefixer",
                                    [
                                        "postcss-reporter",
                                        { clearReportedMessages: true },
                                    ],
                                ],
                            },
                        },
                    },
                    {
                        loader: "sass-loader",
                        options: {
                            sourceMap: true,
                            sassOptions: {
                                outputStyle: "expanded",
                            },
                        },
                    },
                ],
            },
        ],
    },
};
