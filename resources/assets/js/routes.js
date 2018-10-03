import ServiceIndex from './components/service/ServiceIndex'
import LoginForm from './components/login/LoginForm'
import IconIndex from './components/icon/IconIndex'
import GroupIndex from './components/group/GroupIndex'

export const routes = [
  {
    path: '*',
    redirect: {
      name: 'serviceIndex'
    },
    meta: {
      requiresAuth: false
    }
  }, {
    path: '/service',
    component: ServiceIndex,
    name: 'serviceIndex',
    meta: {
      requiresAuth: false
    }
  }, {
    path: '/auth/login',
    component: LoginForm,
    name: 'loginForm',
    path: '/icon',
    meta: {
      requiresAuth: false
    }
  }, {
    path: '/icons',
    component: IconIndex,
    name: 'iconIndex',
    meta: {
      requiresAuth: true
    }
  }, {
    path: '/group',
    component: GroupIndex,
    name: 'groupIndex',
    meta: {
      requiresAuth: true
    }
  }
]