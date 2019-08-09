// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import VueSweetalert2 from 'vue-sweetalert2'
import { http } from './services/config'
import ViaCep from 'vue-viacep'

Vue.use(ViaCep);
Vue.use(VueSweetalert2)
Vue.use(BootstrapVue)
Vue.config.productionTip = false

// Rotina para validação de acesso na determinada rota.
router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.jwt)) {
    if (localStorage.getItem('token')) {
      // Definindo o token no headers no caso de um refresh no navegador.
      http.defaults.headers.common['Authorization'] = localStorage.getItem('token')
    }
    else {
      next({ path: '/' })
    }
  }
  next()
})

new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
