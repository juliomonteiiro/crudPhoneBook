<template>
  <Modal :is-open="isOpen" @close="handleClose">
    <div>
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white">
          {{ contact ? "Editar Contato" : "Novo Contato" }}
        </h2>
        <button
          @click="handleClose"
          class="text-gray-500 hover:text-gray-300 transition-colors"
        >
          <svg
            class="w-6 h-6"
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

      <form @submit.prevent="handleSubmit" class="space-y-4">
        <div>
          <label
            for="name"
            class="block text-sm font-medium text-gray-300 mb-2"
          >
            Nome *
          </label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            required
            @blur="validateName"
            class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-700 text-white transition-colors"
            :class="errors.name ? 'border-red-500' : 'border-gray-600'"
            placeholder="Nome completo"
          />
          <p v-if="errors.name" class="mt-1 text-xs text-red-400">
            {{ errors.name }}
          </p>
        </div>

        <div>
          <label
            for="phone"
            class="block text-sm font-medium text-gray-300 mb-2"
          >
            Telefone *
          </label>
          <input
            id="phone"
            v-model="form.phone"
            type="tel"
            required
            @input="handlePhoneInput"
            @blur="validatePhoneField"
            maxlength="15"
            class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-700 text-white transition-colors"
            :class="errors.phone ? 'border-red-500' : 'border-gray-600'"
            placeholder="(00) 00000-0000"
          />
          <p v-if="errors.phone" class="mt-1 text-xs text-red-400">
            {{ errors.phone }}
          </p>
        </div>

        <div>
          <label
            for="email"
            class="block text-sm font-medium text-gray-300 mb-2"
          >
            E-mail *
          </label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            required
            @input="handleEmailInput"
            @blur="validateEmailField"
            class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-700 text-white transition-colors"
            :class="errors.email ? 'border-red-500' : 'border-gray-600'"
            placeholder="email@exemplo.com"
          />
          <p v-if="errors.email" class="mt-1 text-xs text-red-400">
            {{ errors.email }}
          </p>
        </div>

        <div>
          <label
            for="image"
            class="block text-sm font-medium text-gray-300 mb-2"
          >
            Imagem
          </label>
          <input
            id="image"
            type="file"
            accept="image/*"
            @change="handleImageChange"
            class="w-full px-4 py-2.5 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-700 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-600 file:text-gray-200 hover:file:bg-gray-500"
          />
          <p class="mt-1 text-xs text-gray-400">
            Formatos aceitos: JPG, PNG (máx. 2MB)
          </p>
          <div v-if="imagePreview" class="mt-2">
            <img
              :src="imagePreview"
              alt="Preview"
              class="h-20 w-20 rounded-full object-cover border-2 border-gray-300 border-gray-600"
            />
          </div>
          <div v-else-if="contact?.image" class="mt-2">
            <img
              :src="getImageUrl(contact.image)"
              alt="Current"
              class="h-20 w-20 rounded-full object-cover border-2 border-gray-300 border-gray-600"
            />
          </div>
        </div>

        <div
          v-if="error"
          class="bg-red-50 bg-red-900/20 border border-red-200 border-red-800 text-red-600 text-red-400 px-4 py-3 rounded-lg text-sm"
        >
          {{ error }}
        </div>

        <div class="flex justify-end gap-3 pt-4">
          <button
            type="button"
            @click="handleClose"
            class="px-4 py-2.5 bg-gray-200 bg-gray-700 hover:bg-gray-300 hover:bg-gray-600 text-gray-800 text-gray-200 rounded-lg transition-colors font-medium"
          >
            Cancelar
          </button>
          <button
            type="submit"
            :disabled="loading || !isFormValid"
            class="px-4 py-2.5 bg-blue-500 hover:bg-blue-600 disabled:bg-blue-500 disabled:cursor-not-allowed text-white rounded-lg transition-colors font-medium flex items-center"
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
            {{ loading ? "Salvando..." : "Salvar" }}
          </button>
        </div>
      </form>
    </div>
  </Modal>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import Modal from "../../../components/Modal.vue";
import { useContactsStore } from "../store";
import {
  validateEmail,
  validatePhone,
  formatPhone,
  formatEmail,
} from "../../../utils/validators";

const props = defineProps({
  contact: {
    type: Object,
    default: null,
  },
  isOpen: {
    type: Boolean,
    required: true,
  },
});

const emit = defineEmits(["close", "saved"]);

const contactsStore = useContactsStore();

const form = ref({
  name: "",
  phone: "",
  email: "",
  image: null,
});

const errors = ref({
  name: "",
  phone: "",
  email: "",
});

const imagePreview = ref(null);
const loading = ref(false);
const error = ref("");

const isFormValid = computed(() => {
  return (
    form.value.name.trim() !== "" &&
    form.value.phone.trim() !== "" &&
    form.value.email.trim() !== "" &&
    !errors.value.name &&
    !errors.value.phone &&
    !errors.value.email
  );
});

const validateName = () => {
  if (!form.value.name.trim()) {
    errors.value.name = "Nome é obrigatório";
  } else if (form.value.name.trim().length < 2) {
    errors.value.name = "Nome deve ter pelo menos 2 caracteres";
  } else {
    errors.value.name = "";
  }
};

const validatePhoneField = () => {
  if (!form.value.phone.trim()) {
    errors.value.phone = "Telefone é obrigatório";
  } else if (!validatePhone(form.value.phone)) {
    errors.value.phone = "Telefone inválido. Use o formato (00) 00000-0000";
  } else {
    errors.value.phone = "";
  }
};

const validateEmailField = () => {
  if (!form.value.email.trim()) {
    errors.value.email = "E-mail é obrigatório";
  } else if (!validateEmail(form.value.email)) {
    errors.value.email = "E-mail inválido. Use o formato email@exemplo.com";
  } else {
    errors.value.email = "";
  }
};

const handlePhoneInput = (event) => {
  const formatted = formatPhone(event.target.value);
  form.value.phone = formatted;
  if (errors.value.phone) {
    validatePhoneField();
  }
};

const handleEmailInput = (event) => {
  form.value.email = formatEmail(event.target.value);
  if (errors.value.email) {
    validateEmailField();
  }
};

watch(
  () => props.contact,
  (newContact) => {
    if (newContact) {
      const phoneDigits = newContact.phone
        ? newContact.phone.replace(/\D/g, "")
        : "";
      form.value = {
        name: newContact.name || "",
        phone: phoneDigits ? formatPhone(phoneDigits) : "",
        email: newContact.email || "",
        image: null,
      };
      imagePreview.value = null;
    } else {
      form.value = {
        name: "",
        phone: "",
        email: "",
        image: null,
      };
      imagePreview.value = null;
    }
    errors.value = {
      name: "",
      phone: "",
      email: "",
    };
    error.value = "";
  },
  { immediate: true }
);

watch(
  () => props.isOpen,
  (isOpen) => {
    if (!isOpen) {
      error.value = "";
      imagePreview.value = null;
      errors.value = {
        name: "",
        phone: "",
        email: "",
      };
    }
  }
);

const handleImageChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    if (file.size > 2 * 1024 * 1024) {
      error.value = "A imagem deve ter no máximo 2MB";
      return;
    }
    form.value.image = file;
    const reader = new FileReader();
    reader.onload = (e) => {
      imagePreview.value = e.target.result;
    };
    reader.readAsDataURL(file);
  }
};

const handleSubmit = async () => {
  validateName();
  validatePhoneField();
  validateEmailField();

  if (!isFormValid.value) {
    return;
  }

  loading.value = true;
  error.value = "";

  try {
    const formData = new FormData();
    formData.append("name", form.value.name.trim());
    formData.append("phone", form.value.phone.replace(/\D/g, ""));
    formData.append("email", form.value.email.trim().toLowerCase());
    if (form.value.image) {
      formData.append("image", form.value.image);
    }

    if (props.contact) {
      await contactsStore.updateContact(props.contact.id, formData);
    } else {
      await contactsStore.createContact(formData);
    }

    emit("saved");
    handleClose();
  } catch (err) {
    error.value = err.response?.data?.message || "Erro ao salvar contato";
  } finally {
    loading.value = false;
  }
};

const handleClose = () => {
  form.value = {
    name: "",
    phone: "",
    email: "",
    image: null,
  };
  imagePreview.value = null;
  error.value = "";
  errors.value = {
    name: "",
    phone: "",
    email: "",
  };
  emit("close");
};

const getImageUrl = (imagePath) => {
  if (!imagePath) return null;
  if (imagePath.startsWith("http")) {
    return imagePath;
  }
  const apiUrl = import.meta.env.VITE_API_BASE_URL || "http://127.0.0.1:8000";
  return apiUrl + imagePath;
};
</script>
