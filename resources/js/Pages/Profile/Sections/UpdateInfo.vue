<script setup>
import SessMsg from "@/Components/SessMsg.vue";
import Input from "@/Components/Input.vue";

import { router, useForm } from "@inertiajs/vue3";

const props = defineProps({
  user: Object,
  msgUpdate: String,
  msgVerify: String,
});

const form = useForm({ name: props.user.name, email: props.user.email });

const resendEmail = (e) => {
  router.post(
    route("verification.send"),
    {},
    {
      onStart: () => (e.target.disabled = true),
      onFinish: () => (e.target.disabled = false),
    }
  );
};
</script>

<template>
  <section class="p-6 my-4 bg-white dark:bg-dark-2 rounded-lg">
    <div class="max-w-xl">
      <div class="mb-6">
        <h2 class="h2">Update Information</h2>
        <p>Update your account's profile information and email address.</p>
      </div>

      <SessMsg :msg="msgUpdate" />

      <form
        @submit.prevent="form.patch(route('profile.update'))"
        class="space-y-6"
      >
        <Input
          label="Name"
          icon="id-badge"
          v-model="form.name"
          :error="form.errors.name"
        />
        <Input
          label="Email"
          icon="at"
          v-model="form.email"
          :error="form.errors.email"
        />
        <div v-if="user.email_verified_at === null">
          <SessMsg :msg="msgVerify" />
          <p>Your email address is unverified.</p>
          <button
            type="button"
            @click="resendEmail"
            class="text-blue-500 underline cursor-pointer"
          >
            Click here to re-send the verification email.
          </button>
        </div>

        <button type="submit" class="btn" :disabled="form.processing">
          Save
        </button>
      </form>
    </div>
  </section>
</template>