<script setup>
import { useI18n } from "vue-i18n";
import { ref } from "vue";

const { locale } = useI18n();
const lang = ref(locale.value);

const changeLang = () => {
  locale.value = lang.value;
  localStorage.setItem("locale", lang.value);
};
</script>

<template>
  <select
    v-model="lang"
    @change="changeLang"
    class="px-1 rounded-lg dark:bg-dark py-1"
  >
    <option value="en">EN</option>
    <option value="id">ID</option>
  </select>
</template>