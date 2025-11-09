<template>
  <MainLayout>
    <div
      class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
    >
      <div>
        <h2 class="text-4xl font-extrabold text-white mb-2">Meus Contatos</h2>
        <p class="text-gray-400">Gerencie sua lista de contatos</p>
      </div>
      <button
        @click="openFormModal(null)"
        class="px-6 py-3.5 bg-indigo-500 hover:bg-indigo-600 text-white rounded-xl transition-all duration-200 font-semibold flex items-center gap-2 shadow-lg hover:shadow-xl transform"
      >
        <svg
          class="w-5 h-5"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 4v16m8-8H4"
          />
        </svg>
        Novo Contato
      </button>
    </div>

    <!-- Campo de Busca -->
    <div class="mb-6">
      <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg
            class="h-5 w-5 text-gray-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
            />
          </svg>
        </div>
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Buscar por nome, email ou telefone..."
          class="block w-full pl-10 pr-3 py-3 border border-gray-600 bg-gray-800 text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
        />
        <button
          v-if="searchQuery"
          @click="clearSearch"
          class="absolute inset-y-0 right-0 pr-3 flex items-center"
        >
          <svg
            class="h-5 w-5 text-gray-400 hover:text-white transition-colors"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
      </div>
      <p v-if="contactsStore.pagination.total > 0" class="mt-2 text-sm text-gray-400">
        {{ contactsStore.pagination.total }} contato(s) total(is)
        <span v-if="searchQuery"> - {{ contactsStore.contacts.length }} resultado(s) na busca</span>
      </p>
    </div>

    <!-- Controles de Ordenação -->
    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center gap-4">
      <div class="flex items-center gap-2">
        <svg
          class="h-5 w-5 text-gray-400"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"
          />
        </svg>
        <span class="text-sm text-gray-400 font-medium">Ordenar por:</span>
      </div>
      <div class="flex flex-wrap items-center gap-2">
        <select
          v-model="sortBy"
          @change="handleSortChange"
          class="px-4 py-2 bg-gray-800 border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-sm"
        >
          <option value="name">Nome</option>
          <option value="email">Email</option>
          <option value="created_at">Data de criação</option>
        </select>
        <button
          @click="toggleSortOrder"
          class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors font-medium flex items-center gap-2 text-sm"
          :title="contactsStore.sortOrder === 'asc' ? 'Crescente (A-Z)' : 'Decrescente (Z-A)'"
        >
          <svg
            v-if="contactsStore.sortOrder === 'asc'"
            class="h-4 w-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5 15l7-7 7 7"
            />
          </svg>
          <svg
            v-else
            class="h-4 w-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M19 9l-7 7-7-7"
            />
          </svg>
          {{ contactsStore.sortOrder === 'asc' ? 'A-Z' : 'Z-A' }}
        </button>
      </div>
    </div>

    <ContactList
      :contacts="contactsStore.contacts"
      :loading="contactsStore.loading"
      @view="handleViewContact"
      @edit="openFormModal"
      @delete="openDeleteModal"
    />

    <!-- Controles de Paginação -->
    <div
      v-if="contactsStore.pagination.last_page > 1"
      class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-800 rounded-lg border border-gray-700 p-4"
    >
      <div class="text-sm text-gray-400">
        Mostrando {{ contactsStore.pagination.from }} até {{ contactsStore.pagination.to }} de
        {{ contactsStore.pagination.total }} contatos
      </div>
      <div class="flex items-center gap-2">
        <button
          @click="goToPage(contactsStore.pagination.current_page - 1)"
          :disabled="contactsStore.pagination.current_page === 1 || contactsStore.loading"
          class="px-4 py-2 text-sm bg-gray-700 hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed text-white rounded-lg transition-colors font-medium"
        >
          Anterior
        </button>
        <div class="flex items-center gap-1">
          <button
            v-for="page in visiblePages"
            :key="page"
            @click="goToPage(page)"
            :class="[
              'px-3 py-2 text-sm rounded-lg transition-colors font-medium',
              page === contactsStore.pagination.current_page
                ? 'bg-indigo-500 text-white'
                : 'bg-gray-700 hover:bg-gray-600 text-white'
            ]"
            :disabled="contactsStore.loading"
          >
            {{ page }}
          </button>
        </div>
        <button
          @click="goToPage(contactsStore.pagination.current_page + 1)"
          :disabled="contactsStore.pagination.current_page === contactsStore.pagination.last_page || contactsStore.loading"
          class="px-4 py-2 text-sm bg-gray-700 hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed text-white rounded-lg transition-colors font-medium"
        >
          Próxima
        </button>
      </div>
    </div>

    <ContactFormModal
      :is-open="showFormModal"
      :contact="selectedContact"
      @close="closeFormModal"
      @saved="handleContactSaved"
    />

    <ConfirmModal
      :is-open="showDeleteModal"
      :contact-name="selectedContact?.name || ''"
      :loading="contactsStore.loading"
      @close="closeDeleteModal"
      @confirm="handleDeleteConfirm"
    />
  </MainLayout>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { useRouter } from "vue-router";
import MainLayout from "../../../layouts/MainLayout.vue";
import ContactList from "../components/ContactList.vue";
import ContactFormModal from "../components/ContactFormModal.vue";
import ConfirmModal from "../../../components/ConfirmModal.vue";
import { useContactsStore } from "../store";

const router = useRouter();
const contactsStore = useContactsStore();

const showFormModal = ref(false);
const showDeleteModal = ref(false);
const selectedContact = ref(null);
const searchQuery = ref("");
const sortBy = ref("name");
let searchTimeout = null;

const visiblePages = computed(() => {
  const current = contactsStore.pagination.current_page;
  const last = contactsStore.pagination.last_page;
  const pages = [];
  
  if (last <= 7) {
    for (let i = 1; i <= last; i++) {
      pages.push(i);
    }
  } else {
    if (current <= 3) {
      for (let i = 1; i <= 5; i++) {
        pages.push(i);
      }
      pages.push('...');
      pages.push(last);
    } else if (current >= last - 2) {
      pages.push(1);
      pages.push('...');
      for (let i = last - 4; i <= last; i++) {
        pages.push(i);
      }
    } else {
      pages.push(1);
      pages.push('...');
      for (let i = current - 1; i <= current + 1; i++) {
        pages.push(i);
      }
      pages.push('...');
      pages.push(last);
    }
  }
  
  return pages;
});

const goToPage = async (page) => {
  if (page < 1 || page > contactsStore.pagination.last_page || page === '...') {
    return;
  }
  await contactsStore.loadContacts(
    page, 
    contactsStore.pagination.per_page, 
    searchQuery.value,
    contactsStore.sortBy,
    contactsStore.sortOrder
  );
};

const performSearch = async () => {
  await contactsStore.loadContacts(
    1, 
    contactsStore.pagination.per_page, 
    searchQuery.value,
    contactsStore.sortBy,
    contactsStore.sortOrder
  );
};

const clearSearch = async () => {
  searchQuery.value = '';
  await contactsStore.loadContacts(
    1, 
    contactsStore.pagination.per_page, 
    '',
    contactsStore.sortBy,
    contactsStore.sortOrder
  );
};

const handleSortChange = async () => {
  await contactsStore.loadContacts(
    1,
    contactsStore.pagination.per_page,
    searchQuery.value,
    sortBy.value,
    contactsStore.sortOrder
  );
};

const toggleSortOrder = async () => {
  const newOrder = contactsStore.sortOrder === 'asc' ? 'desc' : 'asc';
  await contactsStore.loadContacts(
    1,
    contactsStore.pagination.per_page,
    searchQuery.value,
    contactsStore.sortBy,
    newOrder
  );
};

watch(searchQuery, () => {
  if (searchTimeout) {
    clearTimeout(searchTimeout);
  }
  searchTimeout = setTimeout(() => {
    performSearch();
  }, 500);
});

watch(() => contactsStore.sortBy, (newSortBy) => {
  if (sortBy.value !== newSortBy) {
    sortBy.value = newSortBy;
  }
});

const handleViewContact = (contact) => {
  router.push(`/contacts/${contact.id}`);
};

const openFormModal = (contact) => {
  selectedContact.value = contact;
  showFormModal.value = true;
};

const closeFormModal = () => {
  showFormModal.value = false;
  selectedContact.value = null;
};

const openDeleteModal = (contact) => {
  selectedContact.value = contact;
  showDeleteModal.value = true;
};

const closeDeleteModal = () => {
  showDeleteModal.value = false;
  selectedContact.value = null;
};

const handleContactSaved = async () => {
  await contactsStore.loadContacts(
    contactsStore.pagination.current_page,
    contactsStore.pagination.per_page,
    searchQuery.value,
    contactsStore.sortBy,
    contactsStore.sortOrder
  );
  closeFormModal();
};

const handleDeleteConfirm = async () => {
  if (selectedContact.value) {
    await contactsStore.deleteContact(selectedContact.value.id);
    closeDeleteModal();
  }
};

onMounted(async () => {
  sortBy.value = contactsStore.sortBy;
  await contactsStore.loadContacts();
});
</script>
