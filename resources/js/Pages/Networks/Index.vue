<template>
    <app-layout title="Networks">
        <template #header>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active" aria-current="page">Networks</li>
                </ol>
            </nav>
        </template>

        <div class="row">
            <div class="col-12 mb-2">
                <link-button :href="route('networks.create')">Add Network</link-button>
            </div>
            <div class="col-12">
                <div class="card p-0">
                    <table class="table table-card">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Range</th>
                            <th>Start - End</th>
                            <th>Hosts</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="network in networks" :key="network.id" class="c-pointer" v-on:click="this.$inertia.visit(route('networks.show', network.id))">
                            <td>{{ network.name }}</td>
                            <td>{{ network.range }}</td>
                            <td>{{ network.range_start }} - {{ network.range_end }}</td>
                            <td>{{ network.hosts }}/{{ network.max_hosts }}</td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
import {defineComponent} from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import LinkButton from "@/Components/LinkButton";

export default defineComponent({
    components: {
        AppLayout,
        LinkButton
    },
    props: {
        networks: Array
    }
});
</script>
