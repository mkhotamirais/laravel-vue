<script setup>
import Input from "@/Components/Input.vue";

import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const showConfirmPassword = ref(false);

const form = useForm({ password: "" });

const submit = () => {
  form.delete(route("profile.destroy"), {
    onFinish: () => form.reset(),
  });
};
</script>

<template>
  <section class="p-6 my-4 bg-white dark:bg-dark-2 rounded-lg">
    <div class="max-w-xl">
      <div class="mb-4">
        <h1 class="h1">Delete Account</h1>
        <p>
          Once your account is deleted, all of its resources data will be
          permanently deleted. This action cannot be undone.
        </p>
      </div>

      <div v-if="showConfirmPassword">
        <form @submit.prevent="submit" class="space-y-6">
          <Input
            type="password"
            label="Confirm Password"
            icon="key"
            v-model="form.password"
            :error="form.errors.password"
          />

          <div class="flex items-center gap-4">
            <button type="submit" class="btn" :disabled="form.processing">
              Confirm
            </button>
            <button
              type="button"
              @click="showConfirmPassword = false"
              class="text-indigo-500 font-medium underline dark:text-indigo-400"
            >
              Cancel
            </button>
          </div>
        </form>
      </div>

      <button
        v-if="!showConfirmPassword"
        @click="showConfirmPassword = true"
        class="px-6 py-2 rounded-lg bg-red-500 text-white"
      >
        <i class="fa-slid fa-triangle-exclamation mr-2"></i>
        Delete Account
      </button>
    </div>
  </section>
</template>