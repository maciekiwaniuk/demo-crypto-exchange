import type { Config } from 'jest';

const config: Config = {
    verbose: true,
    moduleFileExtensions: [
        'js', 'ts', 'vue'
    ],
    transform: {
        // process `*.js` files with `babel-jest`
        ".*\\.(js)$": "babel-jest"
    },
    roots: ["<rootDir>/assets/tests/unit"]
};

export default config;