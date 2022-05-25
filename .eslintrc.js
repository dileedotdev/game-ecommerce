module.exports = {
    env: {
        browser: true,
        es2021: true,
    },
    extends: [
        "eslint:recommended",
        "plugin:vue/vue3-essential",
        "plugin:@typescript-eslint/recommended",
        "prettier",
    ],
    parser: "vue-eslint-parser",
    parserOptions: {
        ecmaVersion: "latest",
        parser: "@typescript-eslint/parser",
        sourceType: "module",
    },
    plugins: ["vue", "@typescript-eslint"],
    rules: {
        "vue/multi-word-component-names": "off",
        "no-undef": "off",
    },
    ignorePatterns: ["**/*.d.ts"],
};
