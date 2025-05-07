<script setup>
import UpdateInfo from "./Sections/UpdateInfo.vue";
import UpdatePassword from "./Sections/UpdatePassword.vue";
import DeleteAccount from "./Sections/DeleteAccount.vue";

defineProps({
  user: Object,
  msgUpdate: String,
  msgVerify: String,
});
</script>

<template>
  <Head title="Profile" />
  <section class="py-4">
    <div class="container">
      <div class="mb-4">
        <h1 class="h1">Profile</h1>
        <hr />
        <UpdateInfo
          :user="user"
          :msgUpdate="msgUpdate"
          :msgVerify="msgVerify"
        />
        <hr />
        <UpdatePassword />
        <hr />
        <DeleteAccount />
      </div>
    </div>
  </section>
</template>