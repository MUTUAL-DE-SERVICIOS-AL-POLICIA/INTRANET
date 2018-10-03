import ServiceIndex from './components/service/ServiceIndex'
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
    path: '/icon',
    component: IconIndex,
    name: 'iconIndex',
    meta: {
      requiresAuth: false
    }
  }, {
    path: '/group',
    component: GroupIndex,
    name: 'groupIndex',
    meta: {
      requiresAuth: false
    }
  }
]