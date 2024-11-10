<script setup>
import Layout from './Layout.vue'
import RepositoryViewComponent from '../Components/RepositoryView.vue'

import { Head, usePage } from '@inertiajs/vue3'
import { ChevronRightIcon } from '@heroicons/vue/20/solid'
import { computed, ref } from 'vue'

const page = usePage()
const repositories = computed(() => page.props.repositories)

const repositoryDetailsRef = ref(null);

function showDetails(repository) {
    repositoryDetailsRef.value.open(repository.id)
}
</script>

<template>
    <Layout>
        <Head title="Repositories" />

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
                <div class="flex shrink-0 items-center gap-x-4">
                    <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm/6 text-gray-900">{{ repository.stars }}</p>
                    </div>
                    <ChevronRightIcon class="h-5 w-5 flex-none text-gray-400" aria-hidden="true" />
                </div>
            </li>
        </ul>
    </Layout>
</template>
