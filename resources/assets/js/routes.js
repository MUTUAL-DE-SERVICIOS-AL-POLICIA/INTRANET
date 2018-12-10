import ServiceIndex from './components/service/ServiceIndex'
import LoginForm from './components/login/LoginForm'
import ChangePassword from './components/login/ChangePassword'
import IconIndex from './components/icon/IconIndex'
import GroupIndex from './components/group/GroupIndex'
import NoticeIndex from './components/notice/NoticeIndex'
import UserIndex from './components/user/UserIndex'

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
    meta: {
      requiresAuth: false
    }
  }, {
    path: '/auth/change_password',
    component: ChangePassword,
    name: 'changePassword',
    meta: {
      requiresAuth: false
    }
  }, {
    path: '/icon',
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
  }, {
    path: '/notice',
    component: NoticeIndex,
    name: 'noticeIndex',
    meta: {
      requiresAuth: true
    }
  }, { 
    path: '/user',
    component: UserIndex,
    name: 'userIndex',
    meta: {
      requiresAuth: true
    }
  }
]