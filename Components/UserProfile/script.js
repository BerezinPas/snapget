import Tabs from '../../assets/scripts/tabs.js'

export default function (el) {
  const tabset = new Tabs({ attr: 'data-tabs' })
  tabset.init()
}
