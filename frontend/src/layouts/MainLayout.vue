<template>
  <div class="min-h-screen bg-gray-900">
    <Navbar />
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <slot />
    </main>
  </div>
</template>

<script setup>
import Navbar from "../components/Navbar.vue";
</script>
