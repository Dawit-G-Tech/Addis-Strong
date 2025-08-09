import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../views/Dashboard.vue';
import Members from '../views/Members.vue';
import Staff from '../views/Staff.vue';
import Classes from '../views/Classes.vue';
import Payments from '../views/Payments.vue';
import Memberships from '../views/Memberships.vue';

const routes = [
  {
    path: '/',
    name: 'Dashboard',
    component: Dashboard
  },
  {
    path: '/members',
    name: 'Members',
    component: Members
  },
  {
    path: '/staff',
    name: 'Staff',
    component: Staff
  },
  {
    path: '/classes',
    name: 'Classes',
    component: Classes
  },
  {
    path: '/payments',
    name: 'Payments',
    component: Payments
  },
  {
    path: '/memberships',
    name: 'Memberships',
    component: Memberships
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
