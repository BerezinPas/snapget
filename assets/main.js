import 'vite/modulepreload-polyfill'
import FlyntComponent from './scripts/FlyntComponent'

import 'lazysizes'

if (import.meta.env.DEV) {
  import('@vite/client')
}

import.meta.glob([
  '../Components/**',
  '../assets/**',
  '!**/*.js',
  '!**/*.scss',
  '!**/*.php',
  '!**/*.twig',
  '!**/screenshot.png',
  '!**/*.md'
])

window.customElements.define(
  'flynt-component',
  FlyntComponent
)

export const apiDomain = window.location.origin === 'http://127.0.0.1' ? 'https://test.snapget.ru' : window.location.origin
// console.log('apiDomain', apiDomain)
// console.log(process.env.NODE_ENV)
