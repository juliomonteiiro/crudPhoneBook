import { createRouter, createWebHistory } from 'vue-router'
import LoginPage from '../modules/auth/pages/LoginPage.vue'
import RegisterPage from '../modules/auth/pages/RegisterPage.vue'
import ContactsPage from '../modules/contacts/pages/ContactsPage.vue'
import ContactDetailPage from '../modules/contacts/pages/ContactDetailPage.vue'
import { useAuthStore } from '../modules/auth/store'

const routes = [
	{
		path: '/login',
		name: 'Login',
		component: LoginPage,
		meta: { requiresGuest: true },
	},
	{
		path: '/register',
		name: 'Register',
		component: RegisterPage,
		meta: { requiresGuest: true },
	},
	{
		path: '/contacts',
		name: 'Contacts',
		component: ContactsPage,
		meta: { requiresAuth: true },
	},
	{
		path: '/contacts/:id',
		name: 'ContactDetail',
		component: ContactDetailPage,
		meta: { requiresAuth: true },
	},
	{
		path: '/',
		redirect: '/contacts',
	},
]

const router = createRouter({
	history: createWebHistory(),
	routes,
})

router.beforeEach(async (to, from, next) => {
	const authStore = useAuthStore()

	if (to.meta.requiresAuth) {
		if (!authStore.isAuthenticated) {
			if (authStore.token) {
				const isAuthenticated = await authStore.checkAuth()
				if (!isAuthenticated) {
					next('/login')
					return
				}
			} else {
				next('/login')
				return
			}
		}
	}

	if (to.meta.requiresGuest && authStore.isAuthenticated) {
		next('/contacts')
		return
	}

	next()
})

export default router
