<template>
    <div v-if="hosts.length > 0" class="col-6">
        <div class="card">
            <div class="card-body pb-0">
                <h5 class="card-title m-0">{{ title }}</h5>
            </div>
            <ul class="list-group">
                <li v-for="host in hosts" class="list-group-item d-flex justify-content-between align-items-center border-bottom">
                    <div class="me-auto">
                        <div class="fw-bold">{{ host.name }}</div>
                        {{ host.address }}
                    </div>
                    <Link :href="route('networks.show', host.network_id)" class="badge bg-primary rounded-pill fs-6 text-decoration-none">{{ host.network_name }}</Link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import {defineComponent} from "vue"
import {Link} from '@inertiajs/inertia-vue3';
import AppLayout from "@/Layouts/AppLayout.vue"

export default defineComponent({
    components: {
        AppLayout,
        Link
    },
    props: {
        title: {
            type: String,
            required: true
        },
        hosts: {
            type: Array,
            required: true
        },
    }
});
</script>
