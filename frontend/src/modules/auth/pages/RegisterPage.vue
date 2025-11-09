<template>
  <div class="min-h-screen bg-gray-900 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
      <div class="bg-gray-800 rounded-2xl shadow-xl p-8 md:p-10 space-y-8">
        <div class="text-center space-y-3">
          <div
            class="inline-flex items-center justify-center w-20 h-20 bg-indigo-500 rounded-2xl shadow-lg mb-4"
          >
            <svg
              class="w-10 h-10 text-white"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"
              />
            </svg>
          </div>
          <h1 class="text-4xl font-extrabold text-indigo-400">Criar Conta</h1>
          <p class="text-gray-300 text-sm font-medium">
            Preencha os dados para criar sua conta
          </p>
        </div>

        <form @submit.prevent="handleRegister" class="space-y-6">
          <div class="space-y-2">
            <label for="name" class="block text-sm font-semibold text-gray-200">
              Nome
            </label>
            <div class="relative">
              <div
                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
              >
                <svg
                  class="h-5 w-5 text-gray-500"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                  />
                </svg>
              </div>
              <input
                id="name"
                v-model="form.name"
                type="text"
                required
                autocomplete="name"
                @blur="validateName"
                class="w-full pl-12 pr-4 py-3.5 border-2 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-700 text-white transition-all duration-200 placeholder-gray-400"
                :class="errors.name ? 'border-red-500' : 'border-gray-600'"
                placeholder="Seu nome completo"
              />
            </div>
            <p v-if="errors.name" class="text-xs text-red-400 mt-1">
              {{ errors.name }}
            </p>
          </div>

          <div class="space-y-2">
            <label
              for="email"
              class="block text-sm font-semibold text-gray-200"
            >
              E-mail
            </label>
            <div class="relative">
              <div
                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
              >
                <svg
                  class="h-5 w-5 text-gray-500"
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
              <input
                id="email"
                v-model="form.email"
                type="email"
                required
                autocomplete="email"
                @input="handleEmailInput"
                @blur="validateEmail"
                class="w-full pl-12 pr-4 py-3.5 border-2 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-700 text-white transition-all duration-200 placeholder-gray-400"
                :class="errors.email ? 'border-red-500' : 'border-gray-600'"
                placeholder="seu@email.com"
              />
            </div>
            <p v-if="errors.email" class="text-xs text-red-400 mt-1">
              {{ errors.email }}
            </p>
          </div>

          <div class="space-y-2">
            <label
              for="password"
              class="block text-sm font-semibold text-gray-200"
            >
              Senha
            </label>
            <div class="relative">
              <div
                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
              >
                <svg
                  class="h-5 w-5 text-gray-500"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                  />
                </svg>
              </div>
              <input
                id="password"
                v-model="form.password"
                :type="showPassword ? 'text' : 'password'"
                required
                autocomplete="new-password"
                @blur="validatePassword"
                class="w-full pl-12 pr-12 py-3.5 border-2 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-700 text-white transition-all duration-200 placeholder-gray-400"
                :class="errors.password ? 'border-red-500' : 'border-gray-600'"
                placeholder="••••••••"
              />
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-gray-300 transition-colors"
                tabindex="-1"
              >
                <svg
                  v-if="showPassword"
                  class="h-5 w-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m3.29 3.29L3 3m0 0l18 18m0-18L3 21"
                  />
                </svg>
                <svg
                  v-else
                  class="h-5 w-5"
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
              </button>
            </div>
            <p v-if="errors.password" class="text-xs text-red-400 mt-1">
              {{ errors.password }}
            </p>
          </div>

          <div class="space-y-2">
            <label
              for="password_confirmation"
              class="block text-sm font-semibold text-gray-200"
            >
              Confirmar Senha
            </label>
            <div class="relative">
              <div
                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
              >
                <svg
                  class="h-5 w-5 text-gray-500"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                  />
                </svg>
              </div>
              <input
                id="password_confirmation"
                v-model="form.password_confirmation"
                :type="showPasswordConfirmation ? 'text' : 'password'"
                required
                autocomplete="new-password"
                @blur="validatePasswordConfirmation"
                class="w-full pl-12 pr-12 py-3.5 border-2 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-700 text-white transition-all duration-200 placeholder-gray-400"
                :class="
                  errors.password_confirmation
                    ? 'border-red-500'
                    : 'border-gray-600'
                "
                placeholder="••••••••"
              />
              <button
                type="button"
                @click="showPasswordConfirmation = !showPasswordConfirmation"
                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-gray-300 transition-colors"
                tabindex="-1"
              >
                <svg
                  v-if="showPasswordConfirmation"
                  class="h-5 w-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m3.29 3.29L3 3m0 0l18 18m0-18L3 21"
                  />
                </svg>
                <svg
                  v-else
                  class="h-5 w-5"
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
              </button>
            </div>
            <p
              v-if="errors.password_confirmation"
              class="text-xs text-red-400 mt-1"
            >
              {{ errors.password_confirmation }}
            </p>
          </div>

          <div
            v-if="error"
            class="bg-red-900/20 border-2 border-red-800 text-red-300 px-4 py-3.5 rounded-xl text-sm font-medium flex items-center gap-2"
          >
            <svg
              class="w-5 h-5 flex-shrink-0"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path
                fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                clip-rule="evenodd"
              />
            </svg>
            <span>{{ error }}</span>
          </div>

          <button
            type="submit"
            :disabled="loading || !isFormValid"
            class="w-full bg-indigo-500 hover:bg-indigo-600 disabled:bg-gray-500 text-white font-bold py-4 px-6 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:transform-none disabled:cursor-not-allowed"
          >
            <span v-if="loading" class="flex items-center">
              <svg
                class="animate-spin h-5 w-5 mr-2"
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
              Criando conta...
            </span>
            <span v-else class="flex items-center gap-2">
              <span>Criar Conta</span>
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
                  d="M13 7l5 5m0 0l-5 5m5-5H6"
                />
              </svg>
            </span>
          </button>

          <div class="text-center pt-4">
            <p class="text-sm text-gray-400">
              Já tem uma conta?
              <router-link
                to="/login"
                class="font-semibold text-indigo-400 hover:text-indigo-300 transition-colors"
              >
                Entrar
              </router-link>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "../store";
import {
  validateEmail as validateEmailFormat,
  formatEmail,
} from "../../../utils/validators";

const router = useRouter();
const authStore = useAuthStore();

const form = ref({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const errors = ref({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const loading = ref(false);
const error = ref("");
const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

const isFormValid = computed(() => {
  return (
    form.value.name.trim() !== "" &&
    form.value.email.trim() !== "" &&
    form.value.password !== "" &&
    form.value.password_confirmation !== "" &&
    !errors.value.name &&
    !errors.value.email &&
    !errors.value.password &&
    !errors.value.password_confirmation
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

const validateEmail = () => {
  if (!form.value.email.trim()) {
    errors.value.email = "E-mail é obrigatório";
  } else if (!validateEmailFormat(form.value.email)) {
    errors.value.email = "E-mail inválido. Use o formato email@exemplo.com";
  } else {
    errors.value.email = "";
  }
};

const validatePassword = () => {
  if (!form.value.password) {
    errors.value.password = "Senha é obrigatória";
  } else if (form.value.password.length < 6) {
    errors.value.password = "Senha deve ter pelo menos 6 caracteres";
  } else {
    errors.value.password = "";
    if (form.value.password_confirmation) {
      validatePasswordConfirmation();
    }
  }
};

const validatePasswordConfirmation = () => {
  if (!form.value.password_confirmation) {
    errors.value.password_confirmation = "Confirmação de senha é obrigatória";
  } else if (form.value.password !== form.value.password_confirmation) {
    errors.value.password_confirmation = "As senhas não coincidem";
  } else {
    errors.value.password_confirmation = "";
  }
};

const handleEmailInput = (event) => {
  form.value.email = formatEmail(event.target.value);
  if (errors.value.email) {
    validateEmail();
  }
};

const handleRegister = async () => {
  validateName();
  validateEmail();
  validatePassword();
  validatePasswordConfirmation();

  if (!isFormValid.value) {
    return;
  }

  loading.value = true;
  error.value = "";

  const result = await authStore.register(
    form.value.name.trim(),
    form.value.email.trim().toLowerCase(),
    form.value.password
  );

  if (result.success) {
    router.push("/contacts");
  } else {
    error.value = result.message || "Erro ao criar conta";
  }

  loading.value = false;
};
</script>
