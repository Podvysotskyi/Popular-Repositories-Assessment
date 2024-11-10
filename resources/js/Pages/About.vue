<script setup>
import Layout from './Layout.vue'

import {Head } from '@inertiajs/vue3'
</script>

<template>
    <Head title="About" />

    <Layout>
        <template #default>
            <p class="mb-2">
                Using whatever frameworks/technologies you feel most comfortable with, complete the following:
            </p>
            <ol class="ml-5 list-disc text-justify">
                <li class="mb-2">
                    Using the GitHub API, retrieve the top 100 most starred public PHP projects and store
                    the list of repositories in a MySQL table. The application must be able to create a new
                    schema and table if they do not already exist. The table must contain the repository ID,
                    name, owner username, URL, created date, last push date, description, and number of
                    stars. This process should also be able to update existing project details.
                </li>
                <li class="mb-2">
                    Using the data in the table created in step 1, create an interface that displays a list of the
                    GitHub repositories and allows the user to click through to view details on each one. Be
                    sure to include all of the fields in step 1 – displayed in either the list or detailed view. For
                    the interface, you may use any UI frameworks (Vue, React, etc) you see fit.
                </li>
                <li class="mb-2">
                    Be sure to publish your code to a public GitHub repository and make commits to show
                    and document your process. Create a README file with a description of the architecture
                    chosen and notes on installation of the application - and make sure to upload it to your
                    GitHub repository.
                </li>
            </ol>
        </template>
    </Layout>
</template>
