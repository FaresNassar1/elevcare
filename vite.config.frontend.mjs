import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import cp from 'vite-plugin-cp';

const FrontEndPath = 'modules/Frontend/resources/assets';
const outputDir = 'front';
const cpOutputDir = 'public/' + outputDir + '/assets';

export default defineConfig({
    plugins: [
        laravel({
            buildDirectory: outputDir,
            input: [
                `${FrontEndPath}/js/app.js`,
                `${FrontEndPath}/js/landing-page.js`,
                `${FrontEndPath}/js/form-builder.js`,
                `${FrontEndPath}/js/home.js`,
                `${FrontEndPath}/js/inner.js`
            ],
        }),
        cp({
            targets: [
                {src: FrontEndPath + '/fonts', dest: cpOutputDir + '/fonts', flatten: false},
                {src: FrontEndPath + '/iconmoon', dest: cpOutputDir + '/iconmoon', flatten: false},
                {src: FrontEndPath + '/images', dest: cpOutputDir + '/images'},
            ]
        })
    ],
    build: {
        emptyOutDir: false,
    },
});
