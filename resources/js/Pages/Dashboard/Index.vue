<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="h4 font-weight-bold">
                Dashboard
            </h2>
        </template>

        <div class="row">
            <div v-if="newHosts.length > 0" class="col-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="card-title m-0">New Hosts</h5>
                    </div>
                    <ul class="list-group">
                        <li v-for="host in newHosts" class="list-group-item d-flex justify-content-between align-items-center border-bottom">
                            <div class="me-auto">
                                <div class="fw-bold">{{ host.name }}</div>
                                {{ host.address }}
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ host.network_name }}</span>
                        </li>
                    </ul>
                </div>
            </div>
    </app-layout>
</template>

<script>
import {defineComponent} from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"

export default defineComponent({
    components: {
        AppLayout
    },
    props: {
        newHosts: Array,
    }
});
</script>
