<script setup>

import {Head, Link, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const characteristic = usePage().props.characteristic;
</script>

<template>
  <Head :title="'Characteristic ' + characteristic.id" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Characteristic {{ characteristic.id }}</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            {{ characteristic.name }}
            {{ characteristic.slug }}
            {{ characteristic.description }}
        </div>
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
          <Link :href="route('characteristics.destroy', characteristic)" method="delete" as="button" type="button">Delete</Link>
          <br>
          <Link :href="route('characteristics.edit', characteristic)" method="get" as="button" type="button">Update</Link>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>

</style>