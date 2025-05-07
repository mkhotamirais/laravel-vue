<script setup>
import { ref } from "vue";
import { userMenus } from "../common";

defineProps({ user: Object });
const openNavUser = ref(false);
</script>

<template>
  <div v-if="user">
    <button class="px-2" @click="openNavUser = true">
      <i class="fa-solid fa-user"></i>
    </button>
    <div
      @click="openNavUser = false"
      class="fixed inset-0 bg-black/10 z-50 transition-all"
      :class="openNavUser ? 'opacity-100 visible' : 'opacity-0 invisible'"
    >
      <div
        @click="(e) => e.stopPropagation()"
        class="absolute right-0 w-80 bg-white dark:bg-dark h-full transition-all"
        :class="openNavUser ? 'translate-x-0' : 'translate-x-full'"
      >
        <div class="p-3">
          <div class="flex items-center justify-between">
            <p>{{ user.name }}</p>
            <button @click="openNavUser = false" class="py-1 px-2">
              <i class="fa-solid fa-times"></i>
            </button>
          </div>
          <div>
            <Link
              v-for="(u, i) in userMenus"
              :key="i"
              @click="openNavUser = false"
              :href="route(u.name)"
              class="block py-2 px-4 w-full hover:bg-dark-2 hover:text-white rounded-lg transition-all"
              >{{ u.label }}</Link
            >
            <Link
              @click="openNavUser = false"
              :href="route('logout')"
              method="post"
              as="button"
              class="p-2 bg-primary text-white rounded-lg mt-2 text-sm hover:underline"
              >Logout</Link
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>