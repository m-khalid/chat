import about from './components/about.vue'
import search from './components/search.vue'
import setting from './components/setting.vue'
import viewFriends from './components/viewFriends.vue'
import viewMessages from './components/viewMessages.vue'
import mlogin from './components/authentication/mlogin.vue'
import mregister from './components/authentication/mregister.vue'


export default[
  {path:'/', component: viewMessages, meta: { requiresAuth: true}},
  {path:'/viewMessages', component: viewMessages, meta: { requiresAuth: true}},
  {path:'/search', component: search, meta: { requiresAuth: true}},
  {path:'/setting', component: setting, meta: { requiresAuth: true}},
  {path:'/viewFriends', component: viewFriends, meta: { requiresAuth: true}},
  {path:'/about', component: about, meta: { requiresAuth: true}},
  {path:'/login', component: mlogin, meta: { requiresVisitor: true}},
  {path:'/register', component: mregister, meta: { requiresVisitor: true}}
]
