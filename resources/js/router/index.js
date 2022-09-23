import Vue from 'vue'
import Router from 'vue-router'
import Home from '../views/home'
import Login from '../views/login'
import Register from '../views/register'
import store from '../store'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/dashboard',
      name: 'Home',
      component: Home,
    },
    {
      path: '/login',
      alias: '/',
      name: 'Login',
      component: Login,
    },
    {
      path: '/register',
      name: 'Register',
      component: Register,
    },
  ]
})

router.beforeEach(async (to, from, next) => {
  if(to.path != '/login')
    await store.dispatch('auth/me');
  if (((to.path != '/login')&&(to.path != '/register')) && (router.app.$store.state.auth.user == null)) {
      return next('/login');
  }
  if ((to.path == '/login') && (router.app.$store.state.auth.user != null)) {
      return next('/dashboard');
  }
  return next();
})

export default router
