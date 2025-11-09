<template>
  <Teleport to="body">
    <Transition name="modal">
      <div
        v-if="isOpen"
        class="fixed inset-0 z-[9999] overflow-y-auto custom-scrollbar"
        @click.self="handleClose"
      >
        <div class="flex items-center justify-center min-h-screen px-4 py-4">
          <div
            class="fixed inset-0 bg-black bg-opacity-70 transition-opacity"
            @click="handleClose"
          ></div>

          <div
            class="relative bg-gray-800 rounded-xl shadow-2xl max-w-lg w-full mx-auto transform transition-all"
            role="dialog"
            aria-modal="true"
            @click.stop
          >
            <div class="p-6">
              <slot />
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { Teleport, Transition } from "vue";

const props = defineProps({
  isOpen: {
    type: Boolean,
    required: true,
  },
});

const emit = defineEmits(["close"]);

const handleClose = () => {
  emit("close");
};
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-active .bg-white,
.modal-leave-active .bg-white {
  transition: transform 0.3s ease, opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

.modal-enter-from .bg-white,
.modal-leave-to .bg-white {
  transform: scale(0.95);
  opacity: 0;
}
</style>
