<script setup>
import Layout from './Layout.vue'
import RepositoryViewComponent from '../Components/RepositoryView.vue'

import {Head, router, usePage} from '@inertiajs/vue3'
import { ChevronRightIcon, StarIcon } from '@heroicons/vue/20/solid'
import { computed, ref } from 'vue'
import axios from "axios";

const page = usePage()
const repositories = computed(() => page.props.repositories)

const repositoryDetailsRef = ref(null);

function showDetails(repository) {
    repositoryDetailsRef.value.open(repository.id)
}

const update = async () => {
    await axios.post('/api/repositories')

    router.reload()
}
</script>

<template>
    <Head title="Repositories" />

    <Layout>
        <template #nav-bar>
            <button type="button" class="mt-3 block rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" @click="update">
                Update
            </button>
        </template>

        <template #side-bar>
            <div class="border-t border-gray-200 pb-3 py-2">
                <div class="mx-2 grid">
                    <button type="button" class="mt-3 block rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" @click="update">
                        Update
                    </button>
                </div>
            </div>
        </template>

        <template #default>
            <RepositoryViewComponent ref="repositoryDetailsRef" />

            <ul role="list" class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                <li v-for="repository in repositories" :key="repository.id" class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6 cursor-pointer" @click="showDetails(repository)">
                    <div class="flex min-w-0 gap-x-4">
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm/6 font-semibold text-gray-900">
                                {{ repository.name }}
                            </p>
                        </div>
                    </div>
                    <div class="flex shrink-0 items-center gap-x-1">
                        <StarIcon class="h-5 w-5 flex-none text-gray-400" aria-hidden="true" />
                        <div class="hidden sm:flex sm:flex-col sm:items-end">
                            <p class="text-sm/6 text-gray-900">
                                {{ repository.stars }}
                            </p>
                        </div>
                        <ChevronRightIcon class="ml-2 h-5 w-5 flex-none text-gray-400" aria-hidden="true" />
                    </div>
                </li>
            </ul>
        </template>
    </Layout>
</template>
