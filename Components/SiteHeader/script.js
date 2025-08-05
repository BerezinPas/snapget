import { disableBodyScroll, enableBodyScroll } from 'body-scroll-lock'
import delegate from 'delegate-event-listener'
import { buildRefs } from '@/assets/scripts/helpers.js'

export default function (el) {
  let isMenuOpen
  const refs = buildRefs(el)
  const navigationHeight = parseInt(window.getComputedStyle(el).getPropertyValue('--navigation-height')) || 0

  if (window.location.pathname.includes('profile')) {
    const profileLinkClickDelegate = delegate('[data-ref="authMenuItem"]', onProfileMenuItemClick)
    el.addEventListener('click', profileLinkClickDelegate)
  }

  const isDesktopMediaQuery = window.matchMedia('(min-width: 744px)')
  isDesktopMediaQuery.addEventListener('change', onBreakpointChange)

  const menuButtonClickDelegate = delegate('[data-ref="menuButton"]', onMenuButtonClick)
  el.addEventListener('click', menuButtonClickDelegate)

  const themeButtonClickDelegate = delegate('[data-ref="themeColor"]', onThemeButtonClick)
  el.addEventListener('click', themeButtonClickDelegate)

  const profileButtonClickDelegate = delegate('[data-ref="authUserpic"]', onProfileButtonClick)
  el.addEventListener('click', profileButtonClickDelegate)

  onBreakpointChange()

  document.addEventListener('click', function (e) {
    if (e.target.closest('[data-ref="menuButton"]')) return

    isMenuOpen = false
    refs.menuButton.classList.remove('is-active')
    el.removeAttribute('data-status')
    enableBodyScroll(refs.menu)
  })

  function onMenuButtonClick (e) {
    isMenuOpen = !isMenuOpen

    if (isMenuOpen) {
      refs.menuButton.classList.add('is-active')
      el.setAttribute('data-status', 'menuIsOpen')
      disableBodyScroll(refs.menu)
    } else {
      refs.menuButton.classList.remove('is-active')
      el.removeAttribute('data-status')
      enableBodyScroll(refs.menu)
    }
  }

  function onProfileButtonClick (e) {
    refs.authMenu.classList.toggle('is-active')
  }

  function onProfileMenuItemClick (e) {
    e.preventDefault()

    window.location.href = e.target.href
    window.location.reload()
  }

  function onThemeButtonClick () {
    if (document.body.getAttribute('data-theme') === 'dark') {
      document.body.setAttribute('data-theme', 'light')
      setCookie('theme-color', 'light')
    } else {
      document.body.setAttribute('data-theme', 'dark')
      setCookie('theme-color', 'dark')
    }
  }

  function setCookie (name, value, options = {}) {
    options = {
      path: '/',
      // при необходимости добавьте другие значения по умолчанию
      ...options
    }

    if (options.expires instanceof Date) {
      options.expires = options.expires.toUTCString()
    }

    let updatedCookie = encodeURIComponent(name) + '=' + encodeURIComponent(value)

    for (const optionKey in options) {
      updatedCookie += '; ' + optionKey
      const optionValue = options[optionKey]
      if (optionValue !== true) {
        updatedCookie += '=' + optionValue
      }
    }

    document.cookie = updatedCookie
  }

  function onBreakpointChange () {
    if (!isDesktopMediaQuery.matches) {
      setScrollPaddingTop()
    }
  }

  function setScrollPaddingTop () {
    const scrollPaddingTop = document.getElementById('wpadminbar')
      ? navigationHeight + document.getElementById('wpadminbar').offsetHeight
      : navigationHeight
    document.documentElement.style.scrollPaddingTop = `${scrollPaddingTop}px`
  }

  return () => {
    isDesktopMediaQuery.removeEventListener('change', onBreakpointChange)
    el.removeEventListener('click', menuButtonClickDelegate)
  }
}
