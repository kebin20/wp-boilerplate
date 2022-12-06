/**
 * Image Optimization
 *
 * - optimize images in /src/ and output them in /dist/
 */
import imagemin from "imagemin";
import webp from "imagemin-webp";
import imageminSvgo from "imagemin-svgo";

const optimizeImages = async () => {
  const IMG_DEST = "dist/img";

  await imagemin(["src/img/*.{jpg,png,gif}"], {
    destination: IMG_DEST,
  });
  console.log(" - JPG and PNGs processed");

  await imagemin(["src/img/*.{jpg,png}"], {
    destination: IMG_DEST,
    plugins: [webp({ lossless: true })],
  });
  console.log(" - JPG and PNGs converted to WebP");

  await imagemin(["src/img/*.svg"], {
    destination: IMG_DEST,
    plugins: [
      imageminSvgo({
        plugins: [
          {
            name: "removeViewBox",
            active: false,
          },
          {
            name: "collapseGroups",
            active: true,
          },
        ],
      }),
    ],
  });
  console.log(" - SVGs processed");
};

/**
 * Cleanup
 *
 * - remove excess files leftover from Webpack
 */
import fs from "fs";

const fileCleanup = async () => {
  const paths = ["./dist/style.js", "./dist/style.js.map"];

  paths.forEach((path) => {
    if (fs.existsSync(path)) {
      fs.unlinkSync(path);
      console.log(` - Unnecessary file removed successfully – (${path})`);
    }
  });
};

/**
 * Run
 */

console.log("Starting Postbuild script:" + "\x1b[32m");
await optimizeImages();
await fileCleanup();
console.log("\x1b[0m" + "Finishing Postbuild script.\n\n");
