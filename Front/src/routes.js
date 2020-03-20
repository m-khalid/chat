import about from './components/about.vue'
import search from './components/search.vue'
import setting from './components/setting.vue'
import viewFriends from './components/viewFriends.vue'
import viewMessages from './components/viewMessages.vue'
import mlogin from './components/authentication/mlogin.vue'
import mregister from './components/authentication/mregister.vue'


export default[
  {path:'/', component: viewMessages},
  {path:'/viewMessages', component: viewMessages},
  {path:'/search', component: search},
  {path:'/setting', component: setting},
  {path:'/viewFriends', component: viewFriends},
  {path:'/about', component: about},
  {path:'/login', component: mlogin},
  {path:'/register', component: mregister}
]
