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

// Función de build
async function build() {
  try {
    if (isWatch) {
      const ctx = await esbuild.context(buildOptions);
      await ctx.watch();
      console.log("👀 Vigilando cambios...");
    } else {
      await esbuild.build(buildOptions);
      console.log("✅ Build completado");
    }
  } catch (error) {
    console.error("❌ Error:", error);
    process.exit(1);
  }
}

build();
