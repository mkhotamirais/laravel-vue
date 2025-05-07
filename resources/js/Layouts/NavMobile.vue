<script setup>
import { ref } from "vue";
import { computed } from "vue";
import { useI18n } from "vue-i18n";

const { t, locale, messages } = useI18n();

const mainMenu = computed(() => messages.value[locale.value].main_menu);
const openNavMobile = ref(false);
</script>

<template>
  <div class="flex md:hidden">
    <button @click="openNavMobile = true" class="px-2 py-1 text-xl">
      <i class="fa-solid fa-bars"></i>
    </button>
    <div
      @click="openNavMobile = false"
      class="fixed !z-50 transition-all inset-0 bg-black/50"
      :class="openNavMobile ? 'opacity-100 visible' : 'opacity-0 invisible'"
    >
      <div
        @click="(e) => e.stopPropagation()"
        class="w-80 bg-white dark:bg-dark-2 h-full absolute left-0 transition-all"
        :class="openNavMobile ? 'translate-x-0' : '-translate-x-100'"
      >
        <div class="p-4">
          <div class="flex items-center justify-between">
            <div>Logo</div>
            <button @click="openNavMobile = true" class="p-2">
              <i class="fa-solid fa-close"></i>
            </button>
          </div>
          <nav class="mt-7">
            <Link
              v-for="(menu, i) in mainMenu"
              :key="i"
              :href="route(menu.name)"
              class="px-2 text-sm block py-2"
              :class="{
                'text-primary':
                  $page.component.toLowerCase() === menu.name.toLowerCase(),
              }"
              @click="openNavMobile = false"
              >{{ menu.label }}</Link
            >
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>