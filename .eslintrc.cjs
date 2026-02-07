module.exports = {
  env: {
    browser: true,
    es2021: true
  },
  extends: [
    'standard',
    'plugin:vue/vue3-essential',
    'plugin:vue/vue3-strongly-recommended',
    'plugin:vue/vue3-recommended',
    'plugin:@typescript-eslint/recommended',
    'plugin:@typescript-eslint/recommended-requiring-type-checking',
    'plugin:@typescript-eslint/strict',
    'plugin:@typescript-eslint/strict-type-checked',
    'plugin:@typescript-eslint/stylistic',
    'plugin:@typescript-eslint/stylistic-type-checked'
  ],
  overrides: [
    {
      env: {
        node: true
      },
      files: [
        '.eslintrc.{js,cjs}'
      ],
      parserOptions: {
        sourceType: 'script'
      }
    }
  ],
  ignorePatterns: [
    'resources/js/wayfinder/**',
    'resources/js/routes/**',
    'resources/js/actions/**',
    'resources/js/Types/generated.ts',
  ],
  parser: 'vue-eslint-parser',
  parserOptions: {
    ecmaVersion: 'latest',
    sourceType: 'module',
    parser: '@typescript-eslint/parser',
    project: './tsconfig.json',
    extraFileExtensions: ['.vue']
  },
  plugins: [
    'vue',
    '@typescript-eslint'
  ],
  rules: {
    // Project conventions (2-space indent, semicolons, trailing commas)
    indent: 'off',
    '@typescript-eslint/indent': ['error', 2],
    semi: 'off',
    '@typescript-eslint/semi': ['error', 'always'],
    'comma-dangle': ['error', 'always-multiline'],
    'space-before-function-paren': ['error', {
      anonymous: 'always',
      named: 'never',
      asyncArrow: 'always',
    }],

    // Allow void for @typescript-eslint/no-floating-promises
    'no-void': ['error', { allowAsStatement: true }],

    // Vue
    'vue/block-order': ['error', { order: ['script', 'template', 'style'] }],
    'vue/html-indent': ['error', 2],
    'vue/multi-word-component-names': 'warn',
    'vue/no-reserved-component-names': 'warn',
    'vue/no-v-html': 'off',
  },
  globals: {
    route: 'readonly',
    axios: 'readonly',
  }
}
