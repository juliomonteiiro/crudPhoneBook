<template>
  <Modal :is-open="isOpen" @close="$emit('close')">
    <div class="text-center">
      <div
        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 bg-red-900/20 mb-4"
      >
        <svg
          class="h-6 w-6 text-red-600 text-red-400"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
          />
        </svg>
      </div>
      <h3 class="text-lg font-medium text-white mb-2">Confirmar Exclusão</h3>
      <p class="text-sm text-gray-400 mb-6">
        Tem certeza que deseja excluir <strong>{{ contactName }}</strong
        >? Esta ação não pode ser desfeita.
      </p>
      <div class="flex justify-center gap-3">
        <button
          @click="$emit('close')"
          class="px-4 py-2 bg-gray-200 bg-gray-700 hover:bg-gray-300 hover:bg-gray-600 text-gray-800 text-gray-200 rounded-lg transition-colors font-medium"
        >
          Cancelar
        </button>
        <button
          @click="$emit('confirm')"
          :disabled="loading"
          class="px-4 py-2 bg-red-500 hover:bg-red-600 disabled:bg-red-500 text-white rounded-lg transition-colors font-medium flex items-center"
        >
          <span v-if="loading" class="mr-2">
            <svg
              class="animate-spin h-4 w-4"
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
          </span>
          {{ loading ? "Excluindo..." : "Excluir" }}
        </button>
      </div>
    </div>
  </Modal>
</template>

<script setup>
import Modal from "./Modal.vue";

defineProps({
  isOpen: {
    type: Boolean,
    required: true,
  },
  contactName: {
    type: String,
    required: true,
  },
  loading: {
    type: Boolean,
    default: false,
  },
});

defineEmits(["close", "confirm"]);
</script>
