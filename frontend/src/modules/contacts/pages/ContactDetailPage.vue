<template>
  <MainLayout>
    <div v-if="loading" class="flex items-center justify-center min-h-[60vh]">
      <div class="text-center">
        <svg
          class="animate-spin h-12 w-12 text-indigo-600 text-indigo-400 mx-auto"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
        >
          <circle
            class="opacity-25"
            cx="12"
            cy="12"
            r="10"
            stroke="currentColor"
            stroke-width="4"
          ></circle>
          <path
            class="opacity-75"
            fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
          ></path>
        </svg>
        <p class="mt-4 text-gray-400">Carregando contato...</p>
      </div>
    </div>

    <div v-else-if="error" class="text-center py-12">
      <div
        class="bg-red-900/20 border-2 border-red-800 rounded-xl p-6 max-w-md mx-auto"
      >
        <svg
          class="w-12 h-12 text-red-400 mx-auto mb-4"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
          />
        </svg>
        <h3 class="text-lg font-semibold text-red-300 mb-2">
          Erro ao carregar contato
        </h3>
        <p class="text-red-400 mb-4">{{ error }}</p>
        <button
          @click="$router.push('/contacts')"
          class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors"
        >
          Voltar para contatos
        </button>
      </div>
    </div>

    <div v-else-if="contact" class="max-w-4xl mx-auto">
      <div class="mb-6">
        <button
          @click="$router.push('/contacts')"
          class="flex items-center gap-2 text-gray-400 hover:text-white transition-colors mb-4"
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
              d="M10 19l-7-7m0 0l7-7m-7 7h18"
            />
          </svg>
          <span class="font-medium">Voltar para contatos</span>
        </button>
      </div>

      <div
        class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-700"
      >
        <div class="bg-indigo-700 p-8 md:p-12">
          <div
            class="flex flex-col md:flex-row items-center md:items-start gap-6"
          >
            <div class="flex-shrink-0">
              <div v-if="contact.image" class="relative">
                <img
                  :src="getImageUrl(contact.image)"
                  :alt="contact.name"
                  class="h-32 w-32 md:h-40 md:w-40 rounded-full object-cover border-4 border-white border-gray-800 shadow-2xl"
                />
              </div>
              <div
                v-else
                class="h-32 w-32 md:h-40 md:w-40 rounded-full bg-white/20 backdrop-blur-sm border-4 border-white/30 flex items-center justify-center text-white text-5xl md:text-6xl font-bold shadow-2xl"
              >
                {{ contact.name.charAt(0).toUpperCase() }}
              </div>
            </div>
            <div class="flex-1 text-center md:text-left">
              <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2">
                {{ contact.name }}
              </h1>
              <p class="text-white/90 text-lg">Contato</p>
            </div>
          </div>
        </div>

        <div class="p-6 md:p-8">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div
              class="bg-blue-50 bg-blue-900/20 rounded-xl p-6 border border-blue-200 border-blue-800"
            >
              <div class="flex items-center gap-4">
                <div class="flex-shrink-0">
                  <div class="bg-blue-500 rounded-xl p-3">
                    <svg
                      class="w-6 h-6 text-white"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                      />
                    </svg>
                  </div>
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-400 mb-1">Telefone</p>
                  <a
                    :href="`tel:${contact.phone.replace(/\D/g, '')}`"
                    class="text-lg font-semibold text-white hover:text-blue-400 transition-colors block truncate"
                  >
                    {{ formatPhoneDisplay(contact.phone) }}
                  </a>
                </div>
              </div>
            </div>

            <div
              class="bg-purple-50 bg-purple-900/20 rounded-xl p-6 border border-purple-200 border-purple-800"
            >
              <div class="flex items-center gap-4">
                <div class="flex-shrink-0">
                  <div class="bg-purple-500 rounded-xl p-3">
                    <svg
                      class="w-6 h-6 text-white"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"
                      />
                    </svg>
                  </div>
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-400 mb-1">E-mail</p>
                  <a
                    :href="`mailto:${contact.email}`"
                    class="text-lg font-semibold text-white hover:text-purple-400 transition-colors block truncate"
                  >
                    {{ contact.email }}
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-end">
            <button
              @click="handleEdit"
              class="px-6 py-3 bg-blue-600 hover:bg-blue-700 bg-blue-500 hover:bg-blue-600 text-white rounded-xl transition-all duration-200 font-semibold flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
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
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                />
              </svg>
              Editar Contato
            </button>
            <button
              @click="handleDelete"
              class="px-6 py-3 bg-red-600 hover:bg-red-700 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-all duration-200 font-semibold flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
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
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                />
              </svg>
              Excluir Contato
            </button>
          </div>
        </div>
      </div>
    </div>

    <ContactFormModal
      :is-open="showFormModal"
      :contact="contact"
      @close="closeFormModal"
      @saved="handleContactSaved"
    />

    <ConfirmModal
      :is-open="showDeleteModal"
      :contact-name="contact?.name || ''"
      :loading="deleting"
      @close="closeDeleteModal"
      @confirm="handleDeleteConfirm"
    />
  </MainLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import MainLayout from "../../../layouts/MainLayout.vue";
import ContactFormModal from "../components/ContactFormModal.vue";
import ConfirmModal from "../../../components/ConfirmModal.vue";
import { getContact, deleteContact } from "../../../api/contacts";
import { formatPhoneDisplay } from "../../../utils/formatters";
import { useContactsStore } from "../store";

const route = useRoute();
const router = useRouter();
const contactsStore = useContactsStore();

const contact = ref(null);
const loading = ref(true);
const error = ref("");
const showFormModal = ref(false);
const showDeleteModal = ref(false);
const deleting = ref(false);

const getImageUrl = (imagePath) => {
  if (!imagePath) return null;
  if (imagePath.startsWith("http")) {
    return imagePath;
  }
  const apiUrl = import.meta.env.VITE_API_BASE_URL || "http://127.0.0.1:8000";
  return apiUrl + imagePath;
};

const loadContact = async () => {
  loading.value = true;
  error.value = "";

  try {
    const response = await getContact(route.params.id);
    contact.value = response.data.data;
  } catch (err) {
    error.value = err.response?.data?.message || "Erro ao carregar contato";
  } finally {
    loading.value = false;
  }
};

const handleEdit = () => {
  showFormModal.value = true;
};

const closeFormModal = () => {
  showFormModal.value = false;
};

const handleContactSaved = async () => {
  await loadContact();
  await contactsStore.loadContacts();
  closeFormModal();
};

const handleDelete = () => {
  showDeleteModal.value = true;
};

const closeDeleteModal = () => {
  showDeleteModal.value = false;
};

const handleDeleteConfirm = async () => {
  if (!contact.value) return;

  deleting.value = true;
  try {
    await deleteContact(contact.value.id);
    await contactsStore.loadContacts();
    router.push("/contacts");
  } catch (err) {
    error.value = err.response?.data?.message || "Erro ao excluir contato";
  } finally {
    deleting.value = false;
    closeDeleteModal();
  }
};

onMounted(() => {
  loadContact();
});
</script>
