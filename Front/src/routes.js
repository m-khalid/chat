import about from './components/about.vue'
import search from './components/search.vue'
import setting from './components/setting.vue'
import viewFriends from './components/viewFriends.vue'
import viewMessages from './components/viewMessages.vue'


export default[
  {path:'', component: viewMessages},
  {path:'/', component: viewMessages},
  {path:'/viewMessages', component: viewMessages},
  {path:'/search', component: search},
  {path:'/setting', component: setting},
  {path:'/viewFriends', component: viewFriends},
  {path:'/about', component: about}
]
