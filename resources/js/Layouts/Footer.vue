<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
  <footer class="h-16 bg-white dark:bg-dark-2">
    <div class="container flex flex-col items-center justify-center">
      <p>Footer</p>
      <div v-if="!user" class="flex gap-2">
        <Link :href="route('login')">Login</Link>
        <Link :href="route('register')">Register</Link>
      </div>
    </div>
  </footer>
</template>