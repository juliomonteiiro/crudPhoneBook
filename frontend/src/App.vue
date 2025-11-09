<template>
  <router-view />
</template>

<script setup>
import { onMounted } from "vue";
import { useAuthStore } from "./modules/auth/store";

const authStore = useAuthStore();

onMounted(async () => {
  if (authStore.token) {
    await authStore.checkAuth();
  }
});
</script>
