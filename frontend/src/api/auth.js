import apiClient from '../config/axios'

export const login = (email, password) =>
	apiClient.post('/api/login', { email, password })

export const register = (name, email, password) =>
	apiClient.post('/api/register', { name, email, password })

export const logout = () =>
	apiClient.post('/api/logout')

export const getUser = () =>
	apiClient.get('/api/user')
