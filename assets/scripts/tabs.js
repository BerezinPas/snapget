/*
 * Helps turn regular anchor links and their referenced elements into
 * tabs. This is achieved by adding appropriate click handlers to the
 * tab buttons and by setting/removing appropriate CSS classes to the
 * tab buttons and tab content elements. To achieve the typical tab
 * look and feel, you will have to apply some corresponding CSS.
 *
 * Takes an optional object with the following possible options:
 * - `attr`: The HTML attribute used to tag the tab navigation element
 * - `name`: The value of the `attr` attribute to look for
 * - `nav_class`: CSS class to set on the tab navigation
 * - `btn_select`: CSS selector for tab button elements
 * - `btn_class`: CSS class to set on all tab buttons
 * - `btn_active`: CSS class to set on active tab buttons
 * - `tab_class`:  CSS class to set on all tab content elements
 * - `tab_active`: CSS class to set on active tab content elements
 * - `tab_hidden`: CSS class to set on hidden tab content elements
 * - `set_frags`: Manipulate URL fragments based on active tab(s)?
 * - `frag_sep`:  The separator character used for multiple URL anchors
 */
export default class Tabs {
  constructor (o) {
    // Set sensible defaults for options
    this.attr = 'data-tabs'
    this.name = null
    this.nav_class = 'tab-nav'
    this.btn_select = null
    this.btn_class = 'tab-button'
    this.btn_active = 'active'
    this.tab_class = 'tab'
    this.tab_active = 'active'
    this.tab_hidden = 'hidden'
    this.set_frags = true
    this.frag_sep = ':'

    // Possibly overwrite with user provided options
    Object.assign(this, o)

    // State variables
    this.tnav = null
    this.tabs = {}
    this.curr = null
  }

  add_class (e, c) {
    e && c && e.classList.add(c)
  }

  rem_class (e, c) {
    e && c && e.classList.remove(c)
  }

  init () {
    // find tab nav based on `attr` and `name`
    if (!(this.tnav = this.find_tnav())) return false

    // get tab nav buttons and current URL anchors
    const btns = this.find_btns()
    const frags = this.frags(this.frag())

    let href, id, tab
    for (const btn of btns) {
      if (!(href = this.find_href(btn))) continue // get button's 'href' attribute
      if (!(id = this.frag(href))) continue // extract anchor string (remove '#')
      if (!(tab = document.getElementById(id))) continue // find corresponding tab

      this.add_class(btn, this.btn_class) // add general button class
      this.add_class(tab, this.tab_class) // add general tab class

      const handler = this.click.bind(this)
      btn.addEventListener('click', handler)

      // Add this tab button and tab content to our state (this.tabs)
      this.tabs[id] = { btn, tab, evt: handler }

      // Mark this tab button as active (this.curr), if appropriate
      if (frags.indexOf(id) >= 0 || this.curr === null) this.curr = id
    }

    if (!Object.keys(this.tabs).length) return false

    this.hide_all() // hide/deactivate all tabs first
    this.show(this.curr) // show only the current tab
    this.add_class(this.tnav, this.nav_class) // add tab nav class
    this.tnav.setAttribute(this.attr + '-set', '') // mark set as processed
    return true
  }

  find_tnav () {
    if (this.tnav) return this.tnav // nav already set, do nothing

    // get all elements with the required attribute set
    const q = `[${this.attr}="${this.name ? this.name : ''}"]`
    const tnavs = document.querySelectorAll(q)

    for (const tnav of tnavs) {
      // make sure this nav/tabset hasn't been processed yet
      if (!tnav.hasAttribute(this.attr + '-set')) return tnav
    }
    return null
  }

  find_btns () {
    return this.btn_select
      ? this.tnav.querySelectorAll(this.btn_select)
      : this.tnav.children
  }

  find_href (e) {
    // If e is an <A> element itself, return it's href attribute
    if (e.nodeName.toLowerCase() === 'a') return e.getAttribute('href')
    // Find the first <A> within e and returns its href attribute
    const a = e.querySelector('a')
    return a ? a.getAttribute('href') : null
  }

  click (evt) {
    evt.preventDefault() // prevent browser from scrolling to anchor
    const href = this.find_href(evt.currentTarget)
    !href || this.open(this.frag(href)) // if `href` given, open the tab
  }

  open (id) {
    if (id === this.curr) return // tab already active
    if (!this.tabs[id]) return // tab doens't belong to this tabset
    if (this.tabs[this.curr]) this.hide(this.curr) // hide current tab
    this.show(id) // show the tab corresponding to the clicked button
    this.update_frags(id) // update URL fragments
    this.curr = id // update state
  }

  update_frags (next) {
    if (!this.set_frags) return
    const frags = this.frags(this.frag()) // get all anchors
    const idx = frags.indexOf(this.curr) // find the active tab in anchors

    // Add tab ID to URL fragments if the previous tab's ID is not in
    // there currently, otherwise replace the previous tab's ID
    frags[idx === -1 ? frags.length : idx] = next
    // replace anchor string with updated version
    /* eslint-disable no-undef */
    history.replaceState(undefined, undefined, '#' + frags.join(this.frag_sep))
  }

  show (id) {
    const t = this.tabs[id]
    this.add_class(t.btn, this.btn_active)
    this.add_class(t.tab, this.tab_active)
    this.rem_class(t.tab, this.tab_hidden)
  }

  hide (id) {
    const t = this.tabs[id]
    this.rem_class(t.btn, this.btn_active)
    this.rem_class(t.tab, this.tab_active)
    this.add_class(t.tab, this.tab_hidden)
  }

  hide_all () {
    for (const id in this.tabs) this.hide(id)
  }

  frag (str = document.URL) {
    const url = str.split('#')
    return (url.length > 1) ? url[1] : ''
  }

  frags (str) {
    return str ? str.split(this.frag_sep) : []
  }

  kill () {
    for (const id in this.tabs) {
      const t = this.tabs[id]

      // Remove all tab classes we might have set
      this.rem_class(t.tab, this.tab_class)
      this.rem_class(t.tab, this.tab_active)
      this.rem_class(t.tab, this.tab_hidden)

      // Remove button classes we might have set
      this.rem_class(t.btn, this.btn_class)
      this.rem_class(t.btn, this.btn_active)

      // Remove the button event listerner
      t.btn.removeEventListener('click', t.evt)
    }

    // Forget all about the tabs and current tab
    this.tabs = {}
    this.curr = null

    // Remove class from nav
    this.rem_class(this.tnav, this.nav_class)

    // Remove the "set" marker from the tab nav element
    this.tnav.removeAttribute(this.attr + '-set')
  }
}
