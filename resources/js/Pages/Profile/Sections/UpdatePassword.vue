<script setup>
import Input from "@/Components/Input.vue";
import SessMsg from "@/Components/SessMsg.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  current_password: "",
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.put(route("profile.password"), {
    onSuccess: () => form.reset(),
    onError: () => form.reset(),
    preserveScroll: true,
  });
};
</script>

<template>
  <section class="p-6 my-4 rounded-lg bg-white dark:bg-dark-2">
    <div class="max-w-xl">
      <div class="mb-6">
        <h2 class="h2">Update Password</h2>
        <p>Update your account's profile information and email address.</p>
      </div>

      <form @submit.prevent="submit" class="space-y-6">
        <Input
          label="Current Password"
          icon="key"
          v-model="form.current_password"
          type="password"
          :error="form.errors.current_password"
        />
        <Input
          label="New Password"
          icon="key"
          v-model="form.password"
          type="password"
          :error="form.errors.password"
        />
        <Input
          label="Confirm New Password"
          icon="key"
          v-model="form.password_confirmation"
          type="password"
          :error="form.errors.password_confirmation"
        />

        <SessMsg v-if="form.recentlySuccessful" msg="saved" />
        <button class="btn" type="submit" :disabled="form.processing">
          Save
        </button>
      </form>
    </div>
  </section>
</template>