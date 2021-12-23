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
                            <td>
                                <ul v-if="ip.ports?.length > 0" class="list-unstyled m-0">
                                    <li v-for="port in ip.ports">
                                        {{ port.port }}
                                        <span v-if="port.service"> ({{ port.service }})</span>
                                    </li>
                                </ul>
                            </td>
                            <td class="text-end">
                                <jet-button type="button" class="btn-sm" v-on:click="modifyIp(ip.address)">Edit</jet-button>
                            </td>
                        </tr>
                        <tr v-else>
                            <td class="text-center" colspan="4">There are no hosts matching the filters.</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <modify-ip-modal ref="modifyIpModal" :network="network" :form="modifyIpForm" v-on:modified="submitModifyIp" v-on:delete="confirmIpDeletion"/>

        <confirmation-modal id="deleteIpModal" ref="deleteIpModal" :form="deleteIpForm" v-on:cancelled="reopenModify" v-on:confirmed="deleteIp">
            <template #title>Delete IP</template>
            <span>Are you sure you want to delete this IP?</span>
        </confirmation-modal>
    </app-layout>
</template>

<script>
import {defineComponent} from "vue"
import {Link} from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue"
import ConfirmationModal from '@/Components/Modals/ConfirmationModal'
import JetButton from "@/Jetstream/Button";
import JetInputError from "@/Jetstream/InputError";
import LinkButton from "@/Components/LinkButton";
import ModifyIpModal from "@/Pages/Networks/Components/ModifyIpModal";

export default defineComponent({
    components: {
        AppLayout,
        ConfirmationModal,
        JetButton,
        JetInputError,
        Link,
        LinkButton,
        ModifyIpModal,
    },
    data: function () {
        return {
            filters: {
                onlyUsed: this.network.hosts !== 0,
            },

            modifyIpForm: null,

            deleteIpForm: this.$inertia.form(),
            ipBeingDeleted: null,
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
    },
    methods: {
        modifyIp(ipAddress) {
            const ip = _.find(this.network.ips, ['address', ipAddress]);
            this.modifyIpForm = this.$inertia.form(JSON.parse(JSON.stringify(ip)));
            this.$refs.modifyIpModal.show();
        },
        submitModifyIp() {
            this.modifyIpForm.post(this.route('networks.ips.store', this.network.id), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.$refs.modifyIpModal.hide();
                }
            });
        },
        reopenModify() {
            this.$refs.deleteIpModal.hide();
            this.$refs.modifyIpModal.show();
        },
        confirmIpDeletion(ipAddress) {
            this.ipBeingDeleted = _.find(this.network.ips, ['address', ipAddress]).id;
            this.$refs.modifyIpModal.hide();
            this.$refs.deleteIpModal.show();
        },
        deleteIp() {
            this.deleteIpForm.delete(route('networks.ips.destroy', [this.network.id, this.ipBeingDeleted]), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.ipBeingDeleted = null;
                    this.modifyIpForm = null;
                    this.$refs.deleteIpModal.hide();
                },
            })
        },
    }
});
</script>
