<script setup>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'

import axios from 'axios'
import { ref } from 'vue'

const isOpen = ref(false)
const repositoryId = ref(null)
const repository = ref(null)

const open = async (id) => {
    if (repositoryId.value === id) {
        isOpen.value = true
        return
    }

    repositoryId.value = id

    let response = await axios.get(`/api/repositories/${repositoryId.value}`)

    if (response.data.id === repositoryId.value) {
        repository.value = response.data
        isOpen.value = true
    }
}

const close = () => {
    isOpen.value = false
}

const update = async () => {
    let response = await axios.post(`/api/repositories/${repositoryId.value}`)

    if (response.data.id === repositoryId.value) {
        repository.value = response.data
    }
}

defineExpose({
    open,
})
</script>

<template>
    <TransitionRoot as="template" :show="isOpen">
        <Dialog class="relative z-10" @close="close">
            <div class="fixed inset-0" />

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
                            <DialogPanel class="pointer-events-auto w-screen max-w-md">
                                <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl" v-if="repository">
                                    <div class="bg-indigo-700 px-4 py-6 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <DialogTitle class="text-base font-semibold text-white">
                                                {{ repository.owner }}/{{ repository.name }}
                                            </DialogTitle>
                                            <div class="ml-3 flex h-7 items-center">
                                                <button type="button" class="relative rounded-md bg-indigo-700 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white" @click="close">
                                                    <span class="absolute -inset-2.5" />
                                                    <span class="sr-only">Close panel</span>
                                                    <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mt-1">
                                            <p class="text-sm text-indigo-300">
                                                <a :href="repository.url" target="_blank">
                                                    {{ repository.url }}
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="relative mt-2 flex-1 px-4 sm:px-6">
                                        <p class="mb-2">{{ repository.description }}</p>

                                        <dl class="divide-y divide-gray-100 border-t border-gray-100">
                                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                <dt class="text-sm/6 font-medium text-gray-900">ID</dt>
                                                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ repository.import_id }}</dd>
                                            </div>
                                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                <dt class="text-sm/6 font-medium text-gray-900">Name</dt>
                                                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ repository.name }}</dd>
                                            </div>
                                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                <dt class="text-sm/6 font-medium text-gray-900">Owner</dt>
                                                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ repository.owner }}</dd>
                                            </div>
                                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                <dt class="text-sm/6 font-medium text-gray-900">Stars</dt>
                                                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ repository.stars }}</dd>
                                            </div>
                                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                <dt class="text-sm/6 font-medium text-gray-900">Created at</dt>
                                                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ repository.created_at }}</dd>
                                            </div>
                                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                <dt class="text-sm/6 font-medium text-gray-900">Pushed at</dt>
                                                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ repository.pushed_at }}</dd>
                                            </div>
                                        </dl>

                                        <div class="grid">
                                            <button type="button" class="mt-3 block rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" @click="update">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
