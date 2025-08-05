import delegate from 'delegate-event-listener'
import tingle from 'tingle.js'
import axios from 'axios'
import { apiDomain } from '../../assets/main'

export default function (el) {
  const favouriteButton = el.querySelector('[data-ref="favouritePost"]')
  if (favouriteButton) {
    const currentUser = Number(favouriteButton.dataset.user)
    const currentPost = Number(favouriteButton.dataset.post)

    el.addEventListener('click', onFavouritePost)

    function onFavouritePost (e) {
      axios.post(apiDomain + '/blog/wp-json/api/favourites', {
        user_id: currentUser,
        post_id: currentPost
      })
        .then(function (response) {
          if (response.data === true) {
            favouriteButton.classList.add('is-active')
          } else {
            favouriteButton.classList.remove('is-active')
          }
        })
        .catch(function (error) {
          console.log(error)
        })
    }

    isPostFavourite()

    async function isPostFavourite () {
      const { data, status } = await axios.get(apiDomain + '/blog/wp-json/api/user', {
        params: {
          user_id: currentUser,
          post_id: currentPost
        }
      })

      if (status !== 200 || !data || typeof data === 'string') {
        return
      }

      if (data === true) {
        favouriteButton.classList.add('is-active')
      }
    }
  }

  const onShareDelegate = delegate('[data-ref="sharePost"]', onSharePost)
  el.addEventListener('click', onShareDelegate)

  function onSharePost (e) {
    // eslint-disable-next-line
    const modalShare = new tingle.modal({
      footer: true,
      stickyFooter: false,
      closeMethods: ['overlay', 'escape']
    })

    modalShare.setContent(document.querySelector('[data-ref="shareContent"]').innerHTML)

    modalShare.addFooterBtn('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.29289 3.29289C3.68342 2.90237 4.31658 2.90237 4.70711 3.29289L12 10.5858L19.2929 3.29289C19.6834 2.90237 20.3166 2.90237 20.7071 3.29289C21.0976 3.68342 21.0976 4.31658 20.7071 4.70711L13.4142 12L20.7071 19.2929C21.0976 19.6834 21.0976 20.3166 20.7071 20.7071C20.3166 21.0976 19.6834 21.0976 19.2929 20.7071L12 13.4142L4.70711 20.7071C4.31658 21.0976 3.68342 21.0976 3.29289 20.7071C2.90237 20.3166 2.90237 19.6834 3.29289 19.2929L10.5858 12L3.29289 4.70711C2.90237 4.31658 2.90237 3.68342 3.29289 3.29289Z" fill="#1A1A1A"/></svg>', 'tingle-modal__close', () => {
      modalShare.close()
      modalShare.destroy()
    })

    modalShare.open()
  }

  return () => {
    el.removeEventListener('click', onShareDelegate)
  }
}
