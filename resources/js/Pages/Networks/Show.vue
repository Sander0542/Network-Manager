<template>
    <app-layout :title="network.name">
        <template #header>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <Link :href="route('networks.index')">Networks</Link>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ network.name }}</li>
                </ol>
            </nav>
        </template>

        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Information</h5>
                        <table class="table table-borderless m-0">
                            <tr>
                                <th>Subnet</th>
                                <td>{{ network.range }}</td>
                            </tr>
                            <tr>
                                <th>Range Start</th>
                                <td>{{ network.range_start }}</td>
                            </tr>
                            <tr>
                                <th>Range End</th>
                                <td>{{ network.range_end }}</td>
                            </tr>
                            <tr>
                                <th>Hosts Used</th>
                                <td>{{ network.hosts }}/{{ network.max_hosts }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br/>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Filters</h5>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" v-model="filters.onlyUsed" id="filterAllIps">
                            <label class="form-check-label" for="filterAllIps">
                                Only used hosts
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="card p-0">
                    <table class="table table-card table-sm">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>IP Address</th>
                            <th>Ports</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="filteredIps.length > 0" v-for="ip in filteredIps" :key="ip.id">
                            <td>{{ ip.name }}</td>
                            <td>{{ ip.address }}</td>
                            <td>{{ ip.ports }}</td>
                            <td></td>
                        </tr>
                        <tr v-else>
                            <td class="text-center" colspan="4">There are no hosts matching the filters.</td>
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
import {Link} from "@inertiajs/inertia-vue3";
import LinkButton from "@/Components/LinkButton";

export default defineComponent({
    components: {
        Link,
        AppLayout,
        LinkButton
    },
    data: function () {
        return {
            filters: {
                onlyUsed: true,
            },
        }
    },
    props: {
        network: Object
    },
    computed: {
        filteredIps: function () {
            return _.filter(this.network.ips, (ip) => {
                if (this.filters.onlyUsed && ip.id == null) {
                    return false;
                }

                return true;
            });
        }
    }
});
</script>
