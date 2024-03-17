import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

const CMSPath = 'modules/Backend/resources/assets';
const outputDir = 'build';

export default defineConfig({
    plugins: [
        laravel({
            buildDirectory: outputDir,
            input: [`${CMSPath}/css/app.css`, `${CMSPath}/js/app.js`],

        }),
    ],
});
