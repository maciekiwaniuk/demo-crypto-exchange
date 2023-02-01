const { defineConfig } = require('cypress')

const dir = 'assets/tests/e2e';

module.exports = defineConfig({
    projectId: '2h35b2',
    e2e: {
        baseUrl: 'http://127.0.0.1:8000',
        downloadsFolder: `${dir}/downloads`,
        fixturesFolder: `${dir}/fixtures`,
        screenshotsFolder: `${dir}/screenshots`,
        videosFolder: `${dir}/videos`,
        supportFile: `${dir}/support/e2e.{js,jsx,ts,tsx}`,
        specPattern: `${dir}/tests/**/*.cy.{js,jsx,ts,tsx}`
    },
});
