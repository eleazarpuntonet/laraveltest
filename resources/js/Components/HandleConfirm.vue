<script setup lang="ts">
import { ref } from 'vue';
import { defineProps, defineEmits, defineExpose } from 'vue';

const show = ref(false);
const message = ref('');

const $emit = defineEmits(['confirm', 'cancel']);

const openModal = (msg: string) => {
    message.value = msg;
    show.value = true;
};

const closeModal = () => {
    show.value = false;
};

defineProps<{
    message: string;
}>();


const exposedMethods = {
  openModal,
  closeModal,
};

defineExpose(exposedMethods);

</script>

<template>
    <div v-if="show"
        class="fixed z-50 inset-0 overflow-y-auto bg-gray-900 bg-opacity-75 transition-all ease-in-out duration-300">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4">
            <div class="max-w-md bg-white rounded-lg overflow-hidden shadow-xl">
                <div class="modal-header px-4 py-5 border-b border-gray-200">
                    <h5 class="text-xl font-medium leading-6 text-gray-900">Warning</h5>
                </div>
                <div class="modal-body p-4">
                    {{ message }}
                </div>
                <div class="modal-footer flex items-center justify-end space-x-2 px-4 py-3 border-t border-gray-200">
                    <button @click="$emit('cancel')"
                        class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 rounded-md border border-gray-200">
                        Cancel
                    </button>
                    <button @click="$emit('confirm')"
                        class="px-3 py-2 text-sm font-medium bg-blue-600 hover:bg-blue-700 rounded-md">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>