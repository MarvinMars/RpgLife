<script setup>

import {Head, useForm, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";

const characteristic = usePage().props.characteristic;

const form = useForm({
  name: characteristic.name,
  slug: characteristic.slug,
  description: characteristic.description,
});

</script>

<template>
  <Head title="Create Characteristic" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Update Characteristic</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
          <form @submit.prevent="form.patch(route('characteristics.update', characteristic))" class="mt-6 space-y-6">
            <div>
              <InputLabel for="name" value="Name" />

              <TextInput
                  id="name"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.name"
                  required
                  autofocus
                  autocomplete="name"
              />

              <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
              <InputLabel for="slug" value="Slug" />

              <TextInput
                  id="slug"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.slug"
                  required
              />

              <InputError class="mt-2" :message="form.errors.slug" />
            </div>

            <div>
              <InputLabel for="description" value="Description" />

              <TextInput
                  id="description"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.description"
                  required
              />

              <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <div class="flex items-center gap-4">
              <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

              <Transition
                  enter-active-class="transition ease-in-out"
                  enter-from-class="opacity-0"
                  leave-active-class="transition ease-in-out"
                  leave-to-class="opacity-0"
              >
                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Updated.</p>
              </Transition>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>

</style>