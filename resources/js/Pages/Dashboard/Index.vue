<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="h4 font-weight-bold">
                Dashboard
            </h2>
        </template>

        <div class="row">
            <hosts-card title="New Hosts" :hosts="newHosts"/>
            <hosts-card title="Updated Hosts" :hosts="updatedHosts"/>
        </div>

    </app-layout>
</template>

<script>
import {defineComponent} from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import HostsCard from "@/Pages/Dashboard/Component/HostsCard";

export default defineComponent({
    components: {
        HostsCard,
        AppLayout,
    },
    props: {
        newHosts: Array,
        updatedHosts: Array,
    }
});
</script>
