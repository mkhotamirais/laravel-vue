<script setup>
import { useForm } from "@inertiajs/vue3";
import Input from "@/Components/Input.vue";

const form = useForm({ password: "" });

const submit = () => {
  form.post(route("password.confirm"), {
    onFinish: () => form.reset(),
  });
};
</script>

<template>
  <Head title=" - Password Confirmation" />
  <section class="container">
    <div
      class="max-w-md my-12 p-8 bg-white dark:bg-dark-2 shadow-lg rounded-lg mx-auto"
    >
      <div class="mb-8 text-center">
        <p>
          This is a secure area of the application. Please confir your password
          before continuing
        </p>
      </div>

      <form @submit.prevent="submit" class="space-y-6">
        <Input
          label="Password"
          type="password"
          icon="key"
          v-model="form.password"
          :error="form.errors.password"
        />
        <button class="btn" :disabled="form.processing">Confirm</button>
      </form>
    </div>
  </section>
</template>