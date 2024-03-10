<script setup>

import {Head, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteQuestForm from "@/Pages/Quests/Partials/DeleteQuestForm.vue";
import { Link } from '@inertiajs/vue3'

const characteristics = usePage().props.characteristics;

</script>

<template>
  <Head title="Characteristics" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Characteristics</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" v-for="characteristic in characteristics" :key="characteristic.id">
          {{ characteristic.name }} <br>
          {{ characteristic.slug }} <br>
          {{ characteristic.description }} <br>
          <Link :href="route('characteristics.destroy', characteristic)" method="delete" as="button" type="button">Delete</Link>
          <br>
          <Link :href="route('characteristics.show', characteristic)" method="get" as="button" type="button">Show</Link>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>

</style>