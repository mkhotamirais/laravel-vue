<script setup>
import { computed } from "vue";
import { useI18n } from "vue-i18n";

const { t, locale, messages } = useI18n();

const mainMenu = computed(() => messages.value[locale.value].main_menu);
</script>

<template>
  <nav class="hidden md:flex">
    <Link
      v-for="(menu, i) in mainMenu"
      :key="i"
      :href="route(menu.name)"
      class="px-2 text-sm"
      :class="{
        'text-primary':
          $page.component.toLowerCase() === menu.name.toLowerCase(),
      }"
      >{{ menu.label }}</Link
    >
  </nav>
</template>