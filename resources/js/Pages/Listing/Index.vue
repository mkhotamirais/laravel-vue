<script setup>
import CardListing from "@/Components/CardListing.vue";
import PaginationLinks from "@/Components/PaginationLinks.vue";
import Input from "@/Components/Input.vue";
import SessMsg from "@/Components/SessMsg.vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const params = route().params;
const page = usePage();
const user = computed(() => page.props.auth.user);

const props = defineProps({
  listings: Object,
  searchTerm: String,
  msg: String,
});

const username = params.user_id
  ? props.listings.data.find((user) => user.user_id == Number(params.user_id))
      .user.name
  : null;

const form = useForm({ search: props.searchTerm });

const search = () => {
  router.get(route("listing.index"), {
    search: form.search,
    user_id: params.user_id,
    tag: params.tag,
  });
};
</script>

<template>
  <Head title="Latest Listings" />

  <section class="py-4">
    <div class="container">
      <div v-if="user && user?.role !== 'user'">
        <Link :href="route('listing.create')" class="btn w-fit">
          <i class="fa-solid fa-plus mr-2"></i>
          Create listing</Link
        >
      </div>
      <SessMsg :msg="msg" />
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
          <Link
            class="px-2 py-1 rounded-md bg-indigo-500 text-white flex items-center gap-2"
            v-if="params.tag"
            :href="route('listing.index', { ...params, tag: null, page: null })"
            >{{ params.tag }}
            <i class="fa-solid fa-xmark"></i>
          </Link>
          <Link
            class="px-2 py-1 rounded-md bg-indigo-500 text-white flex items-center gap-2"
            v-if="params.search"
            :href="
              route('listing.index', { ...params, search: null, page: null })
            "
            >{{ params.search }}
            <i class="fa-solid fa-xmark"></i>
          </Link>
          <Link
            class="px-2 py-1 rounded-md bg-indigo-500 text-white flex items-center gap-2"
            v-if="params.user_id"
            :href="
              route('listing.index', { ...params, user_id: null, page: null })
            "
            >{{ username }}
            <i class="fa-solid fa-xmark"></i>
          </Link>
        </div>

        <div class="w-full sm:w-1/4 mt-2">
          <form @submit.prevent="search">
            <Input
              type="search"
              label=""
              icon="magnifying-glass"
              placeholder="Search.."
              v-model="form.search"
            />
          </form>
        </div>
      </div>

      <div v-if="Object.keys(listings.data).length">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div v-for="listing in listings.data" :key="listing.id">
            <CardListing :listing="listing" />
          </div>
        </div>
        <div class="mt-8">
          <PaginationLinks :paginator="listings" />
        </div>
      </div>
      <div v-else>No listings found</div>
    </div>
  </section>
</template>