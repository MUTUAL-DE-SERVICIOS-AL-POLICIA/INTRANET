import ServiceIndex from './components/service/ServiceIndex'

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
  }
]