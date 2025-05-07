<script setup>
import { switchTheme } from "@/theme";
import SetLocale from "./SetLocale.vue";
import NavDesktop from "./NavDesktop.vue";
import Footer from "./Footer.vue";
import NavUser from "./NavUser.vue";
import NavMobile from "./NavMobile.vue";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
  <Head>
    <meta
      head-key="description"
      name="description"
      content="Laravel Vue dari youtube learn with jon"
    />
  </Head>
  <div class="flex flex-col min-h-screen">
    <header class="h-16 bg-white dark:bg-dark-2 sticky top-0 z-50">
      <div class="container flex gap-4 items-center justify-between">
        <div class="flex items-center gap-3">
          <NavMobile />
          <a href="/">Logo</a>
        </div>
        <NavDesktop />
        <div class="flex gap-4 items-center">
          <button @click="switchTheme">
            <i class="fa-solid fa-circle-half-stroke"></i>
          </button>
          <div>
            <Link
              v-if="user && user.role === 'admin'"
              :href="route('admin.index')"
              class="px-2"
            >
              <i class="fa-solid fa-lock"></i>
            </Link>
          </div>
          <div>
            <SetLocale />
          </div>
          <div>
            <NavUser :user="user" />
          </div>
        </div>
      </div>
    </header>

    <!-- main -->
    <main class="flex-1">
      <slot></slot>
    </main>

    <!-- footer -->
    <Footer />
  </div>
</template>