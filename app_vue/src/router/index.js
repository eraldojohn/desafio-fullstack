import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/Login'
import Users from '@/components/Users'

Vue.use(Router)

export default new Router({
  mode: 'history',
  hash: false,
  routes: [
    { path: '/', name: 'login', component: Login },
    { path: '/users', name: 'users', component: Users, meta: { jwt: true }},
  ]
})
