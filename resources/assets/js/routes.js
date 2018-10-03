import ServiceIndex from './components/service/ServiceIndex'
import IconIndex from './components/icon/IconIndex'

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
    path: '/icon',
    component: IconIndex,
    name: 'iconIndex',
    meta: {
      requiresAuth: false
    }
  }
]