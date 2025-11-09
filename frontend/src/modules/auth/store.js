import { defineStore } from 'pinia'
import { login as loginApi, register as registerApi, logout as logoutApi, getUser as getUserApi } from '../../api/auth'
import router from '../../router'

export const useAuthStore = defineStore('auth', {
	state: () => ({
		token: localStorage.getItem('auth_token') || null,
		user: JSON.parse(localStorage.getItem('auth_user') || 'null'),
		isAuthenticated: !!localStorage.getItem('auth_token'),
	}),

	actions: {
		async login(email, password) {
			try {
				const response = await loginApi(email, password)
				const { token, user } = response.data.data

				this.token = token
				this.user = user
				this.isAuthenticated = true

				localStorage.setItem('auth_token', token)
				localStorage.setItem('auth_user', JSON.stringify(user))

				return { success: true }
			} catch (error) {
				const errorMessage = error.response?.data?.message ||
					error.response?.data?.errors?.email?.[0] ||
					'Credenciais inválidas'
				return {
					success: false,
					message: errorMessage,
				}
			}
		},

		async register(name, email, password) {
			try {
				const response = await registerApi(name, email, password)
				const { token, user } = response.data.data

				this.token = token
				this.user = user
				this.isAuthenticated = true

				localStorage.setItem('auth_token', token)
				localStorage.setItem('auth_user', JSON.stringify(user))

				return { success: true }
			} catch (error) {
				const errorMessage = error.response?.data?.message ||
					error.response?.data?.errors?.email?.[0] ||
					error.response?.data?.errors?.name?.[0] ||
					error.response?.data?.errors?.password?.[0] ||
					'Erro ao criar conta'
				return {
					success: false,
					message: errorMessage,
				}
			}
		},

		async logout() {
			try {
				await logoutApi()
			} catch (error) {
			} finally {
				this.token = null
				this.user = null
				this.isAuthenticated = false
				localStorage.removeItem('auth_token')
				localStorage.removeItem('auth_user')
				router.push('/login')
			}
		},

		async checkAuth() {
			if (!this.token) {
				this.isAuthenticated = false
				return false
			}

			try {
				const response = await getUserApi()
				this.user = response.data.data
				localStorage.setItem('auth_user', JSON.stringify(this.user))
				this.isAuthenticated = true
				return true
			} catch (error) {
				this.logout()
				return false
			}
		},
	},
})

