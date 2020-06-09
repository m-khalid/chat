import Vue from 'vue'
import App from './App.vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import VueRouter from 'vue-router'
import Routes from './routes'
import store from './Store'
import axios from 'axios';
import validator from 'validator';

Vue.use(BootstrapVue);
Vue.use(VueRouter);
Vue.use(validator);

axios.defaults.baseURL='http://localhost:8000/api/'

//Vue.config.productionTip = false
const router = new VueRouter({
  routes: Routes, // short for `routes: routes`
  mode: 'history'
})

new Vue({
  render: h => h(App),
  router: router,
  store: store
}).$mount('#app')
