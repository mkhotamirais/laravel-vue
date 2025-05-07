<script setup>
defineProps({
  paginator: Object,
});

const paginateClass = (link) => {
  return {
    "hover:!bg-slate-300 dark:hover:!bg-slate-500": link.url,
    "!opacity-30": !link.url,
    "font-bold text-indigo-500 dark:!text-indigo-400": link.active,
  };
};

const makeLabel = (label) => {
  if (label.includes("Previous")) {
    return "<<";
  } else if (label.includes("Next")) {
    return ">>";
  } else {
    return label;
  }
};
</script>

<template>
  <div class="flex flex-col gap-4 lg:flex-row justify-between items-center">
    <div
      class="flex flex-wrap items-center rounded-md overflow-hidden shadow-lg"
    >
      <div v-for="(link, i) in paginator.links" :key="i">
        <component
          :is="link.url ? 'Link' : 'span'"
          :href="link.url"
          v-html="makeLabel(link.label)"
          class="border-x border-slate-50 w-12 h-12 grid place-items-center bg-white dark:bg-slate-900 dark:border-slate-800"
          :class="paginateClass(link)"
        />
      </div>
    </div>
    <div>
      <p>
        Showing {{ paginator.from }} to {{ paginator.to }} of
        {{ paginator.total }}
      </p>
    </div>
  </div>
</template>