import { defineStore } from 'pinia'
import * as api from '../../api/contacts'

export const useContactsStore = defineStore('contacts', {
	state: () => ({
		contacts: [],
		loading: false,
		error: null,
		pagination: {
			current_page: 1,
			last_page: 1,
			per_page: 15,
			total: 0,
			from: null,
			to: null,
		},
		sortBy: 'name',
		sortOrder: 'asc',
	}),

	actions: {
		async loadContacts(page = 1, perPage = 15, search = '', sortBy = 'name', sortOrder = 'asc') {
			this.loading = true
			this.error = null
			try {
				const response = await api.getContacts({ 
					page, 
					per_page: perPage, 
					search,
					sort_by: sortBy,
					sort_order: sortOrder
				})
				this.contacts = response.data.data || response.data
				if (response.data.pagination) {
					this.pagination = response.data.pagination
				}
				this.sortBy = sortBy
				this.sortOrder = sortOrder
			} catch (error) {
				this.error = error.response?.data?.message || 'Erro ao carregar contatos'
				throw error
			} finally {
				this.loading = false
			}
		},

		async createContact(formData) {
			this.loading = true
			this.error = null
			try {
				await api.createContact(formData)
				await this.loadContacts(this.pagination.current_page, this.pagination.per_page, '', this.sortBy, this.sortOrder)
			} catch (error) {
				this.error = error.response?.data?.message || 'Erro ao criar contato'
				throw error
			} finally {
				this.loading = false
			}
		},

		async updateContact(id, formData) {
			this.loading = true
			this.error = null
			try {
				await api.updateContact(id, formData)
				await this.loadContacts(this.pagination.current_page, this.pagination.per_page, '', this.sortBy, this.sortOrder)
			} catch (error) {
				this.error = error.response?.data?.message || 'Erro ao atualizar contato'
				throw error
			} finally {
				this.loading = false
			}
		},

		async deleteContact(id) {
			this.loading = true
			this.error = null
			try {
				await api.deleteContact(id)
				await this.loadContacts(this.pagination.current_page, this.pagination.per_page, '', this.sortBy, this.sortOrder)
			} catch (error) {
				this.error = error.response?.data?.message || 'Erro ao excluir contato'
				throw error
			} finally {
				this.loading = false
			}
		},
	},
})
