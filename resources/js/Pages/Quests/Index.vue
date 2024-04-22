<script setup>

import {Head, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from '@inertiajs/vue3'

const quests = usePage().props.quests;

</script>

<template>
  <Head title="Quests" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Quests</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" v-for="quest in quests" :key="quest.id">
          {{ quest.name }} <br>
          {{ quest.slug }} <br>
          {{ quest.description }} <br>
          <Link :href="route('quests.destroy', quest)" method="delete" as="button" type="button">Delete</Link>
          <br>
          <Link :href="route('quests.show', quest)" method="get" as="button" type="button">Show</Link>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>

</style>