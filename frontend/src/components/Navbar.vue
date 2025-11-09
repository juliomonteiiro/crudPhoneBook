<template>
  <nav class="bg-gray-800 border-b border-gray-700 shadow-sm">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center gap-3">
          <div
            class="w-10 h-10 bg-indigo-500 rounded-xl flex items-center justify-center shadow-md"
          >
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
          <h1 class="text-xl font-bold text-indigo-400">Agenda Telefônica</h1>
        </div>
        <div class="flex items-center gap-3">
          <div
            class="flex items-center gap-3 px-4 py-2 bg-gray-700/50 rounded-lg border border-gray-600/50"
          >
            <div
              class="w-9 h-9 bg-indigo-500 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-md"
            >
              {{ userInitials }}
            </div>
            <div class="hidden sm:block">
              <p class="text-sm font-medium text-gray-200 leading-tight">
                {{ user?.name }}
              </p>
              <p class="text-xs text-gray-400 leading-tight">
                {{ user?.email }}
              </p>
            </div>
          </div>
          <button
            @click="handleLogout"
            class="p-2.5 text-gray-400 hover:text-red-400 hover:bg-gray-700/50 rounded-lg transition-all duration-200 group"
            title="Sair"
          >
            <svg
              class="w-5 h-5 group-hover:scale-110 transition-transform"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { computed } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "../modules/auth/store";

const router = useRouter();
const authStore = useAuthStore();

const user = computed(() => authStore.user);

const userInitials = computed(() => {
  if (!user.value?.name) return "U";
  const names = user.value.name.split(" ");
  if (names.length >= 2) {
    return (names[0][0] + names[names.length - 1][0]).toUpperCase();
  }
  return user.value.name.substring(0, 2).toUpperCase();
});

const handleLogout = async () => {
  await authStore.logout();
  router.push("/login");
};
</script>
