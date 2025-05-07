<script setup>
import PaginationLinks from "@/Components/PaginationLinks.vue";
import RoleSelect from "@/Components/RoleSelect.vue";
import SessMsg from "@/Components/SessMsg.vue";
import Input from "@/Components/Input.vue";
import { router, useForm } from "@inertiajs/vue3";

defineProps({ users: Object, msg: String });

const params = route().params;
const form = useForm({ search: params.search });

const search = () => {
  router.get(
    route("admin.index", { search: form.search, user_role: params.user_role })
  );
};

const toggleRole = (e) => {
  if (e.target.checked) {
    router.get(
      route("admin.index", {
        search: form.search,
        user_role: "user",
      })
    );
  } else {
    router.get(
      route("admin.index", {
        search: form.search,
        user_role: null,
      })
    );
  }
};
</script>

<template>
  <Head title="Admin Dashboard" />

  <section>
    <div class="container py-4">
      <div class="my-2">
        <SessMsg :msg="msg" />
      </div>
      <div class="flex items-center gap-2 py-4">
        <!-- Search form -->
        <form @submit.prevent="search">
          <Input
            type="search"
            label=""
            icon="magnifying-glass"
            placeholder="Search.."
            v-model="form.search"
            class="!mb-0"
          />
        </form>
        <Link
          class="px-2 py-1 rounded-md bg-indigo-500 text-white flex items-center gap-2"
          v-if="params.search"
          :href="route('admin.index', { ...params, search: null, page: null })"
          >{{ params.search }}
          <i class="fa-solid fa-xmark"></i>
        </Link>
      </div>

      <!-- toggle role btn -->
      <div class="my-2">
        <input
          @input="toggleRole"
          :checked="params.user_role"
          type="checkbox"
          id="toggleRole"
          class=""
        />
        <label for="toggleRole" class="">Show role "user"</label>
      </div>
      <!-- Table -->
      <table
        class="bg-white dark:bg-slate-800 w-full rounded-lg overflow-hidden ring-1 ring-slate-300"
      >
        <thead>
          <tr class="bg-slate-600 text-slate-300 uppercase text-xs text-left">
            <th class="w-3/6 p-3">Name</th>
            <th class="w-2/6 p-3">Role</th>
            <th class="w-1/6 p-3">Listings</th>
            <th class="w-1/6 p-3 text-right">View</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-slate-300 divide-dashed">
          <tr v-for="user in users.data" :key="user.id">
            <td class="w-3/6 py-5 px-3">
              <p class="font-bold mb-1">{{ user.name }}</p>
              <p class="font-light text-xs">{{ user.email }}</p>
            </td>
            <td class="w-2/6 py-5 px-3">
              <RoleSelect :user="user" />
            </td>
            <td class="w-1/6 py-5 px-3">
              <div class="flex items-center gap-6">
                <div class="flex items-center gap-1">
                  <p>{{ user.listings.filter((l) => l.approved).length }}</p>
                  <i class="fa-solid fa-circle-check text-green-500"></i>
                </div>
                <div class="flex items-center gap-1">
                  <p>{{ user.listings.filter((l) => !l.approved).length }}</p>
                  <i class="fa-solid fa-circle-xmark text-red-500"></i>
                </div>
              </div>
            </td>
            <td class="w-1/6 py-5 px-3 text-right">
              <Link
                :href="route('user.show', user.id)"
                class="fa-solid fa-up-right-from-square px-3 text-indigo-400"
              ></Link>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="mt-6">
        <PaginationLinks :paginator="users" />
      </div>
    </div>
  </section>
</template>