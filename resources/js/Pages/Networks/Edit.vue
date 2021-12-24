<template>
    <app-layout :title="network.name">
        <template #header>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <Link :href="route('networks.index')">Networks</Link>
                    </li>
                    <li class="breadcrumb-item">
                        <Link :href="route('networks.show', this.network.id)">{{ network.name }}</Link>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </template>

        <div class="row">
            <div class="col-6">
                <div class="card p-0">
                    <div class="card-body">
                        <div v-show="updateForm.errors.alert" class="alert alert-danger" role="alert">
                            {{ updateForm.errors.alert }}
                        </div>
                        <form @submit.prevent="submitUpdate">
                            <div class="mb-3">
                                <jet-label for="storeNetworkName" value="Name"/>
                                <jet-input required id="storeNetworkName" type="text" v-model="updateForm.name" :class="{ 'is-invalid': updateForm.errors.name }" autocomplete="network-name"/>
                                <jet-input-error :message="updateForm.errors.name"/>
                            </div>
                            <div class="mb-3">
                                <jet-label for="storeNetworkRange" value="Range"/>
                                <jet-input required id="storeNetworkRange" type="text" v-model="updateForm.range" :class="{ 'is-invalid': updateForm.errors.range }" autocomplete="network-range" placeholder="0.0.0.0/0"/>
                                <jet-input-error :message="updateForm.errors.range"/>
                            </div>
                            <jet-button>Save</jet-button>
                            <jet-button type="button" color="danger" class="float-end" v-on:click="confirmNetworkDeletion">Delete</jet-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <confirmation-modal id="deleteNetworkModal" ref="deleteNetworkModal" :form="deleteForm" v-on:cancelled="this.$refs.deleteNetworkModal.hide()" v-on:confirmed="deleteNetwork">
            <template #title>Delete Network</template>
            <span>Are you sure you want to delete this network? This also removes all the hosts in this network.</span>
        </confirmation-modal>
    </app-layout>
</template>

<script>
import {defineComponent} from "vue"
import {Link} from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue"
import ConfirmationModal from '@/Components/Modals/ConfirmationModal'
import JetButton from "@/Jetstream/Button";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import LinkButton from "@/Components/LinkButton";

export default defineComponent({
    components: {
        AppLayout,
        ConfirmationModal,
        JetButton,
        JetInput,
        JetInputError,
        JetLabel,
        Link,
        LinkButton,
    },
    data: function () {
        return {
            updateForm: this.$inertia.form({
                name: this.network.name,
                range: this.network.range,
            }),

            deleteForm: this.$inertia.form(),
        }
    },
    props: {
        network: Object
    },
    methods: {
        submitUpdate() {
            this.updateForm.put(this.route('networks.update', this.network.id), {
                preserveScroll: true,
                preserveState: true,
            });
        },
        confirmNetworkDeletion() {
            this.$refs.deleteNetworkModal.show();
        },
        deleteNetwork() {
            this.deleteForm.delete(route('networks.destroy', this.network.id), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.$refs.deleteNetworkModal?.hide();
                }
            })
        },
    }
});
</script>
