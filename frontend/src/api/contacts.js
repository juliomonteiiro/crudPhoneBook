import apiClient from '../config/axios'

export const getContacts = (params = {}) => {
	const queryParams = new URLSearchParams();
	if (params.page) queryParams.append('page', params.page);
	if (params.per_page) queryParams.append('per_page', params.per_page);
	if (params.search) queryParams.append('search', params.search);
	if (params.sort_by) queryParams.append('sort_by', params.sort_by);
	if (params.sort_order) queryParams.append('sort_order', params.sort_order);
	
	const queryString = queryParams.toString();
	return apiClient.get(`/api/contacts${queryString ? `?${queryString}` : ''}`)
}

export const getContact = (id) =>
	apiClient.get(`/api/contacts/${id}`)

export const createContact = (formData) =>
	apiClient.post('/api/contacts', formData, {
		headers: {
			'Content-Type': 'multipart/form-data',
		},
	})

export const updateContact = (id, formData) => {
	return apiClient.post(`/api/contacts/${id}`, formData, {
		headers: {
			'Content-Type': 'multipart/form-data',
		},
	})
}

export const deleteContact = (id) =>
	apiClient.delete(`/api/contacts/${id}`)
