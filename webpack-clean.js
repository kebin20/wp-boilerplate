/**
 * Clean
 *
 * - remove files not needed for build
 */
import fs from "fs";

const clean = async () => {
  const paths = [
    "./dist/",
    "./node_modules/",
    "./vendor/",
    "./composer.lock",
    "./package-lock.json",
    "./style.css",
    "./style.css.map",
  ];

  paths.forEach((path) => {
    if (fs.existsSync(path)) {
      fs.rmSync(path, {
        recursive: true,
      });
      console.log(` - Removed successfully - (${path})`);
    }
  });
};

console.log("Starting cleanup:" + "\x1b[32m");
await clean();
console.log("\x1b[0m" + "Finished cleanup.\n");
