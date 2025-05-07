<script setup>
import Input from "../../Components/Input.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<template>
  <Head title="Register" />

  <section class="">
    <div class="container">
      <div
        class="p-6 lg:p-8 my-12 w-full sm:w-2/3 lg:w-1/2 bg-white dark:bg-dark-2 mx-auto rounded-lg shadow"
      >
        <div class="mb-4">
          <h1 class="h1">register</h1>
          <p>
            Already have an account?
            <Link :href="route('login')" class="link">Login</Link>
          </p>
        </div>

        <form @submit.prevent="submit">
          <Input
            label="Name"
            icon="id-badge"
            placeholder="Your name"
            v-model="form.name"
            :error="form.errors.name"
          />
          <Input
            label="Email"
            icon="at"
            placeholder="example@email.com"
            v-model="form.email"
            :error="form.errors.email"
          />
          <Input
            label="Password"
            type="password"
            placeholder="********"
            icon="key"
            v-model="form.password"
            :error="form.errors.password"
          />
          <Input
            label="Password Confirmation"
            type="password"
            placeholder="********"
            icon="key"
            v-model="form.password_confirmation"
          />

          <p class="text-slate-500 text-sm">
            By creating an account, you agree to our Terms of Service and
            Privacy Policy
          </p>

          <br />
          <button type="submit" class="btn" :disabled="form.processing">
            Register
          </button>
        </form>
      </div>
    </div>
  </section>
</template>