import { createRouter, createWebHistory } from 'vue-router';

// Import components
import Dashboard from '../views/Dashboard.vue';
import Members from '../views/Members.vue';
import Staff from '../views/Staff.vue';
import Classes from '../views/Classes.vue';
import Payments from '../views/Payments.vue';
import Memberships from '../views/Memberships.vue';
import Profile from '../views/Profile.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';

// Role-based dashboard components
import AdminDashboard from '../views/dashboards/AdminDashboard.vue';
import ManagerDashboard from '../views/dashboards/ManagerDashboard.vue';
import TrainerDashboard from '../views/dashboards/TrainerDashboard.vue';
import StaffDashboard from '../views/dashboards/StaffDashboard.vue';
import MemberDashboard from '../views/dashboards/MemberDashboard.vue';

const routes = [
  // Public routes
  {
    path: '/',
    name: 'Landing',
    component: () => import('../views/Landing.vue'),
    meta: { requiresAuth: false }
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: { requiresAuth: false }
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    meta: { requiresAuth: false }
  },

  // Protected routes
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
    meta: { requiresAuth: true }
  },

  // Profile route
  {
    path: '/profile',
    name: 'Profile',
    component: Profile,
    meta: { requiresAuth: true }
  },

  // Admin routes
  {
    path: '/admin',
    meta: { requiresAuth: true, roles: ['admin'] },
    children: [
      {
        path: 'dashboard',
        name: 'AdminDashboard',
        component: AdminDashboard
      },
      {
        path: 'members',
        name: 'AdminMembers',
        component: Members
      },
      {
        path: 'staff',
        name: 'AdminStaff',
        component: Staff
      },
      {
        path: 'classes',
        name: 'AdminClasses',
        component: Classes
      },
      {
        path: 'payments',
        name: 'AdminPayments',
        component: Payments
      },
      {
        path: 'memberships',
        name: 'AdminMemberships',
        component: Memberships
      }
    ]
  },

  // Manager routes
  {
    path: '/manager',
    meta: { requiresAuth: true, roles: ['manager'] },
    children: [
      {
        path: 'dashboard',
        name: 'ManagerDashboard',
        component: ManagerDashboard
      },
      {
        path: 'members',
        name: 'ManagerMembers',
        component: Members
      },
      {
        path: 'classes',
        name: 'ManagerClasses',
        component: Classes
      },
      {
        path: 'payments',
        name: 'ManagerPayments',
        component: Payments
      },
      {
        path: 'memberships',
        name: 'ManagerMemberships',
        component: Memberships
      }
    ]
  },

  // Trainer routes
  {
    path: '/trainer',
    meta: { requiresAuth: true, roles: ['trainer'] },
    children: [
      {
        path: 'dashboard',
        name: 'TrainerDashboard',
        component: TrainerDashboard
      },
      {
        path: 'classes',
        name: 'TrainerClasses',
        component: Classes
      },
      {
        path: 'sessions',
        name: 'TrainerSessions',
        component: () => import('../views/TrainerSessions.vue')
      }
    ]
  },

  // Staff routes
  {
    path: '/staff',
    meta: { requiresAuth: true, roles: ['staff'] },
    children: [
      {
        path: 'dashboard',
        name: 'StaffDashboard',
        component: StaffDashboard
      },
      {
        path: 'attendance',
        name: 'StaffAttendance',
        component: () => import('../views/StaffAttendance.vue')
      },
      {
        path: 'equipment',
        name: 'StaffEquipment',
        component: () => import('../views/StaffEquipment.vue')
      }
    ]
  },

  // Member routes
  {
    path: '/member',
    meta: { requiresAuth: true, roles: ['member'] },
    children: [
      {
        path: 'dashboard',
        name: 'MemberDashboard',
        component: MemberDashboard
      },
      {
        path: 'classes',
        name: 'MemberClasses',
        component: () => import('../views/MemberClasses.vue')
      },
      {
        path: 'bookings',
        name: 'MemberBookings',
        component: () => import('../views/MemberBookings.vue')
      },
      {
        path: 'payments',
        name: 'MemberPayments',
        component: () => import('../views/MemberPayments.vue')
      }
    ]
  },

  // Catch all route
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: () => import('../views/NotFound.vue')
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Navigation guard for authentication and role-based access
router.beforeEach(async (to, from, next) => {
  // Check if route requires authentication
  if (to.meta.requiresAuth) {
    try {
      // Check if user is authenticated
      const response = await fetch('/api/user');
      if (!response.ok) {
        // Not authenticated, redirect to login
        return next('/login');
      }

      const user = await response.json();
      const userRole = user.role?.role_name || 'user';

      // Check if route has role restrictions
      if (to.meta.roles && !to.meta.roles.includes(userRole)) {
        // User doesn't have required role, redirect to their dashboard
        return next(`/${userRole}/dashboard`);
      }

      next();
    } catch (error) {
      console.error('Auth check error:', error);
      return next('/login');
    }
  } else {
    // Public route, allow access
    next();
  }
});

export default router;
