<script setup>
import { router } from "@inertiajs/vue3";

const props = defineProps({
  listing: Object,
  user: Object,
  canModify: Boolean,
});

const deleteListing = () => {
  if (confirm("Are you sure you want to delete this listing?")) {
    router.delete(route("listing.destroy", props.listing.id));
  }
};

const toggleApprove = () => {
  let msg = props.listing.approved ? "Unapprove" : "Approve";
  if (confirm(`Are you sure you want to ${msg} this listing?`)) {
    router.put(route("admin.approve", props.listing.id));
  }
};
</script>

<template>
  <Head title=" - Listing Detail" />
  <section class="container my-2">
    <!-- Admin -->
    <div
      v-if="$page.props.auth.user && $page.props.auth.user.role === 'admin'"
      class="bg-white dark:bg-dark-2 mb-6 p-6 rounded-md font-medium flex items-center justify-between my-2"
    >
      <p>
        This listing is {{ listing.approved ? "approved" : "not approved" }}
      </p>
      <button
        @click.prevent="toggleApprove"
        class="bg-slate-600 px-3 py-1 rounded-md text-white"
      >
        {{ listing.approved ? "Unapprove" : "Approve" }}
      </button>
    </div>
    <div class="flex gap-4 py-4 bg-white dark:bg-dark-2 rounded-lg p-6">
      <div class="w-1/4 rounded-md overflow-hidden">
        <img
          :src="
            listing.image
              ? `/storage/${listing.image}`
              : '/storage/images/logo-mkhotami.png'
          "
          class="w-full h-full object-cover object-center"
          alt=""
        />
      </div>
      <div class="w-3/4">
        <!-- listing info -->
        <div class="mb-6">
          <div class="flex items-end justify-between mb-2">
            <p class="text-slate-400 w-full border-b">Listing detail</p>
            <!-- Edit and delete -->
            <div v-if="canModify" class="pl-4 flex items-center gap-4">
              <!-- <div class="pl-4 flex items-center gap-4"> -->
              <Link
                :href="route('listing.edit', listing.id)"
                class="link hover:underline flex items-center gap-2"
              >
                <i class="fa-solid fa-pen-to-square"></i>
                Edit
              </Link>
              <button
                @click="deleteListing"
                type="button"
                class="link hover:underline flex items-center gap-2 !text-red-500"
              >
                <i class="fa-solid fa-trash"></i>
                Delete
              </button>
            </div>
          </div>
          <h3 class="font-bold text-2xl mb-4">{{ listing.title }}</h3>
          <p>{{ listing.description }}</p>
        </div>
        <!-- contact info -->
        <div class="mb-6">
          <p class="text-slate-400 w-full border-b mb-2">Contact Info</p>
          <!-- email -->
          <div v-if="listing.email" class="flex items-center mb-2 gap-2">
            <i class="fa-solid fa-at"></i>
            <p>Email:</p>
            <a :href="`https://mailto:${listing.email}`" class="link">{{
              listing.email
            }}</a>
          </div>
          <!-- link -->
          <div v-if="listing.link" class="flex items-center mb-2 gap-2">
            <i class="fa-solid fa-up-right-from-square"></i>
            <p>External Link:</p>
            <a :href="listing.link" class="link">{{ listing.link }}</a>
          </div>
          <!-- user -->
          <div v-if="listing.link" class="flex items-center mb-2 gap-2">
            <i class="fa-solid fa-user"></i>
            <p>Listed by:</p>
            <Link :href="route('home', { user_id: user.id })" class="link">{{
              user.name
            }}</Link>
          </div>
        </div>
        <!-- tags -->
        <div v-if="listing.tags" class="mb-6">
          <p class="text-slate-400 w-full border-b mb-2">Tags</p>
          <div class="flex items-center gap-3">
            <div v-for="tag in listing.tags.split(',')" :key="tag">
              <Link
                :href="route('home', { tag })"
                class="bg-slate-500 text-white px-2 py-1 rounded-full hover:bg-slate-700 dark:hover:bg-slate-900"
              >
                {{ tag }}
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>