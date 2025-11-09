<template>
  <div>
    <div v-if="loading" class="text-center py-12">
      <svg
        class="animate-spin h-8 w-8 text-blue-400 mx-auto"
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
      <p class="mt-4 text-gray-400">Carregando contatos...</p>
    </div>

    <div
      v-else-if="contacts.length === 0"
      class="text-center py-12 bg-gray-800 rounded-lg border border-gray-700"
    >
      <svg
        class="mx-auto h-12 w-12 text-gray-500"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
        />
      </svg>
      <h3 class="mt-2 text-sm font-medium text-white">Nenhum contato</h3>
      <p class="mt-1 text-sm text-gray-400">
        Comece adicionando um novo contato.
      </p>
    </div>

    <div
      v-else
      class="bg-gray-800 rounded-lg border border-gray-700 shadow-sm overflow-hidden"
    >
      <div class="divide-y divide-gray-700 max-h-[600px] overflow-y-auto custom-scrollbar">
        <div
          v-for="contact in contacts"
          :key="contact.id"
          class="p-4 hover:bg-gray-700/50 transition-colors"
        >
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4 flex-1 min-w-0">
              <div class="flex-shrink-0">
                <img
                  v-if="contact.image"
                  :src="getImageUrl(contact.image)"
                  :alt="contact.name"
                  class="h-12 w-12 rounded-full object-cover border-2 border-gray-600"
                />
                <div
                  v-else
                  class="h-12 w-12 rounded-full bg-indigo-500 flex items-center justify-center text-white text-lg font-bold"
                >
                  {{ contact.name.charAt(0).toUpperCase() }}
                </div>
              </div>
              <div class="flex-1 min-w-0">
                <h3 class="text-lg font-semibold text-white truncate">
                  {{ contact.name }}
                </h3>
                <div
                  class="mt-1 flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-1 sm:space-y-0"
                >
                  <p class="text-sm text-gray-400 flex items-center">
                    <svg
                      class="w-4 h-4 mr-1.5 text-gray-500"
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
                    {{ formatPhoneDisplay(contact.phone) }}
                  </p>
                  <p class="text-sm text-gray-400 flex items-center">
                    <svg
                      class="w-4 h-4 mr-1.5 text-gray-500"
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
                    {{ contact.email }}
                  </p>
                </div>
              </div>
            </div>
            <div class="flex items-center gap-2 ml-4 flex-shrink-0">
              <button
                @click="$emit('view', contact)"
                class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg transition-colors font-medium flex items-center gap-1.5"
              >
                <svg
                  class="w-4 h-4"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                  />
                </svg>
                Ver
              </button>
              <button
                @click="$emit('edit', contact)"
                class="px-4 py-2 text-sm bg-blue-600 hover:bg-blue-700 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors font-medium"
              >
                Editar
              </button>
              <button
                @click="$emit('delete', contact)"
                class="px-4 py-2 text-sm bg-red-600 hover:bg-red-700 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors font-medium"
              >
                Excluir
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { formatPhoneDisplay } from "../../../utils/formatters";

defineProps({
  contacts: {
    type: Array,
    required: true,
  },
  loading: {
    type: Boolean,
    default: false,
  },
});

defineEmits(["view", "edit", "delete"]);

const getImageUrl = (imagePath) => {
  if (!imagePath) return null;
  if (imagePath.startsWith("http")) {
    return imagePath;
  }
  const apiUrl = import.meta.env.VITE_API_BASE_URL || "http://127.0.0.1:8000";
  return apiUrl + imagePath;
};
</script>
