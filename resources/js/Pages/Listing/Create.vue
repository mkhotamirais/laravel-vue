<script setup>
import Input from "@/Components/Input.vue";
import TextArea from "@/Components/TextArea.vue";
import ImageUpload from "@/Components/ImageUpload.vue";

import { useForm } from "@inertiajs/vue3";

const form = useForm({
  title: null,
  description: null,
  tags: null,
  email: null,
  link: null,
  image: null,
});
</script>

<template>
  <Head title="Create Listing" />

  <section class="py-4">
    <div class="mb-6 container">
      <h1 class="h1">Create Listing</h1>

      <form @submit.prevent="form.post(route('listing.store'))" class="">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <div class="space-y-6">
            <Input
              label="Title"
              icon="heading"
              placeholder="My new listing"
              v-model="form.title"
              :error="form.errors.title"
            />
            <Input
              label="Tags (separate with comma)"
              icon="tags"
              placeholder="one, two, three"
              v-model="form.tags"
              :error="form.errors.tags"
            />
            <TextArea
              label="Description"
              icon="newspaper"
              placeholder="This is my listing description"
              v-model="form.description"
              :error="form.errors.description"
            />
          </div>
          <div class="space-y-6">
            <Input
              label="Email"
              icon="at"
              placeholder="example@email.com"
              v-model="form.email"
              :error="form.errors.email"
            />
            <Input
              label="External Link"
              icon="up-right-from-square"
              placeholder="https://example.com"
              v-model="form.link"
              :error="form.errors.link"
            />
            <ImageUpload @image="(e) => (form.image = e)" />
          </div>
        </div>

        <div class="mt-6">
          <button type="submit" class="btn" :disabled="form.processing">
            Create
          </button>
        </div>
      </form>
    </div>
  </section>
</template>