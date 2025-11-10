import * as esbuild from "esbuild";
import { sassPlugin } from "esbuild-sass-plugin";
import { promises as fs } from "fs";

const isWatch = process.argv.includes("--watch");
const isProd = process.argv.includes("--prod");

// Configuración principal
const buildOptions = {
  entryPoints: ["public/src/ts/app.ts"],
  bundle: true,
  outfile: "public/js/app.js",
  minify: isProd,
  sourcemap: !isProd,
  target: "es2020",
  plugins: [
    sassPlugin({
      type: "css",
    }),
    {
      name: "extract-css",
      setup(build) {
        // Extraer el CSS a style.css
        build.onEnd(async (result) => {
          if (result.outputFiles) {
            // Buscar el archivo CSS
            const cssFile = result.outputFiles.find((f) =>
              f.path.endsWith(".css")
            );
            // Buscar el archivo JS
            const jsFile = result.outputFiles.find((f) =>
              f.path.endsWith(".js")
            );

            if (cssFile) {
              await fs.writeFile("public/css/style.css", cssFile.contents);
              console.log("✅ public/css/style.css generado");
            }

            if (jsFile) {
              await fs.writeFile("public/js/app.js", jsFile.contents);
              console.log("✅ public/js/app.js generado");
            }

            // Generar sourcemaps si existen
            if (!isProd) {
              const cssMapFile = result.outputFiles.find((f) =>
                f.path.endsWith(".css.map")
              );
              const jsMapFile = result.outputFiles.find((f) =>
                f.path.endsWith(".js.map")
              );

              if (cssMapFile) {
                await fs.writeFile(
                  "public/css/style.css.map",
                  cssMapFile.contents
                );
              }
              if (jsMapFile) {
                await fs.writeFile("public/js/app.js.map", jsMapFile.contents);
              }
            }
          }
        });
      },
    },
  ],
  loader: {
    ".ts": "ts",
    ".tsx": "tsx",
  },
  write: false, // Necesario para acceder a outputFiles
};

// Configuración para home.scss
const homeStylesOptions = {
  entryPoints: ["public/src/styles/home.scss"],
  bundle: true,
  outfile: "public/css/home.css",
  minify: isProd,
  sourcemap: !isProd,
  plugins: [
    sassPlugin({
      type: "css",
    }),
    {
      name: "extract-home-css",
      setup(build) {
        build.onEnd(async (result) => {
          if (result.outputFiles) {
            const cssFile = result.outputFiles.find((f) =>
              f.path.endsWith(".css")
            );

            if (cssFile) {
              await fs.writeFile("public/css/home.css", cssFile.contents);
              console.log("✅ public/css/home.css generado");
            }

            if (!isProd) {
              const cssMapFile = result.outputFiles.find((f) =>
                f.path.endsWith(".css.map")
              );
              if (cssMapFile) {
                await fs.writeFile(
                  "public/css/home.css.map",
                  cssMapFile.contents
                );
              }
            }
          }
        });
      },
    },
  ],
  write: false,
};

// Configuración para services.scss
const servicesStylesOptions = {
  entryPoints: ["public/src/styles/services.scss"],
  bundle: true,
  outfile: "public/css/services.css",
  minify: isProd,
  sourcemap: !isProd,
  plugins: [
    sassPlugin({
      type: "css",
    }),
    {
      name: "extract-services-css",
      setup(build) {
        build.onEnd(async (result) => {
          if (result.outputFiles) {
            const cssFile = result.outputFiles.find((f) =>
              f.path.endsWith(".css")
            );

            if (cssFile) {
              await fs.writeFile("public/css/services.css", cssFile.contents);
              console.log("✅ public/css/services.css generado");
            }

            if (!isProd) {
              const cssMapFile = result.outputFiles.find((f) =>
                f.path.endsWith(".css.map")
              );
              if (cssMapFile) {
                await fs.writeFile(
                  "public/css/services.css.map",
                  cssMapFile.contents
                );
              }
            }
          }
        });
      },
    },
  ],
  write: false,
};

// Configuración para single-service.scss
const singleServiceStylesOptions = {
  entryPoints: ["public/src/styles/single-service.scss"],
  bundle: true,
  outfile: "public/css/single-service.css",
  minify: isProd,
  sourcemap: !isProd,
  plugins: [
    sassPlugin({
      type: "css",
    }),
    {
      name: "extract-single-service-css",
      setup(build) {
        build.onEnd(async (result) => {
          if (result.outputFiles) {
            const cssFile = result.outputFiles.find((f) =>
              f.path.endsWith(".css")
            );

            if (cssFile) {
              await fs.writeFile("public/css/single-service.css", cssFile.contents);
              console.log("✅ public/css/single-service.css generado");
            }

            if (!isProd) {
              const cssMapFile = result.outputFiles.find((f) =>
                f.path.endsWith(".css.map")
              );
              if (cssMapFile) {
                await fs.writeFile(
                  "public/css/single-service.css.map",
                  cssMapFile.contents
                );
              }
            }
          }
        });
      },
    },
  ],
  write: false,
};

// Función de build
async function build() {
  try {
    if (isWatch) {
      const ctx = await esbuild.context(buildOptions);
      const homeCtx = await esbuild.context(homeStylesOptions);
      const servicesCtx = await esbuild.context(servicesStylesOptions);
      const singleServiceCtx = await esbuild.context(singleServiceStylesOptions);
      await ctx.watch();
      await homeCtx.watch();
      await servicesCtx.watch();
      await singleServiceCtx.watch();
      console.log("👀 Vigilando cambios en app.ts, home.scss, services.scss y single-service.scss...");
    } else {
      await esbuild.build(buildOptions);
      await esbuild.build(homeStylesOptions);
      await esbuild.build(servicesStylesOptions);
      await esbuild.build(singleServiceStylesOptions);
      console.log("✅ Build completado");
    }
  } catch (error) {
    console.error("❌ Error:", error);
    process.exit(1);
  }
}

build();
