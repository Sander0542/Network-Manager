<template>
    <modal ref="modal" id="modify-ip-modal" max-width="lg">
        <div class="modal-dialog modal-lg">
            <div v-if="form" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ form.address }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="submit">
                    <div class="modal-body">
                        <div class="mb-3">
                            <jet-label for="modifyNetworkId" value="Network"/>
                            <jet-input id="modifyNetworkId" disabled type="text" v-model="network.name" :class="{ 'is-invalid': form.errors.networkId }"/>
                            <jet-input-error :message="form.errors.networkId"/>
                        </div>
                        <div class="mb-3">
                            <jet-label for="modifyIpName" value="Name"/>
                            <jet-input id="modifyIpName" type="text" v-model="form.name" :class="{ 'is-invalid': form.errors.name }" autocomplete="name"/>
                            <jet-input-error :message="form.errors.name"/>
                        </div>
                        <div class="mb-3">
                            <jet-label value="Ports"/>
                            <div>
                                <div v-for="(port, index) in form.ports" class="input-group mb-1 is-invalid">
                                    <jet-input type="number" min="0" max="65535" v-model="port.port" :class="{ 'is-invalid': form.errors[`ports.${index}.port`] }" autocomplete="network-port" placeholder="Port"/>
                                    <jet-input type="text" v-model="port.service" :class="{ 'is-invalid': form.errors[`ports.${index}.service`] }" autocomplete="network-service" placeholder="Service"/>
                                    <button class="btn btn-outline-secondary" type="button" v-on:click="removePort(index)">-</button>
                                    <jet-input-error :message="form.errors[`ports.${index}.port`]"/>
                                    <jet-input-error :message="form.errors[`ports.${index}.service`]"/>
                                </div>
                            </div>
                            <jet-input-error :message="form.errors['ports']"/>
                            <jet-button type="button" class="btn-sm" v-on:click="addPort">Add Port</jet-button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button v-if="form.id != null" v-on:click="$emit('delete', form.address)" type="button" class="btn btn-danger me-auto">Delete</button>
                        <button type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                            <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </modal>
</template>

<script>
import {defineComponent} from "vue"
import JetLabel from "@/Jetstream/Label";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetButton from "@/Jetstream/Button";
import Modal from "@/Components/Modals/Modal";

export default defineComponent({
    components: {
        JetButton,
        JetInputError,
        JetInput,
        JetLabel,
        Modal
    },
    props: {
        network: {
            type: Object,
        },
        form: {
            type: Object,
        }
    },
    emits: ['modified', 'delete'],
    methods: {
        submit() {
            this.$emit('modified');
        },
        addPort() {
            this.form.ports.push({});
        },
        removePort(index) {
            this.form.ports.splice(index, 1);
            this.form.clearErrors('ports');
        },
        show() {
            this.$refs.modal.show();
        },
        hide() {
            this.$refs.modal.hide();
        }
    }
});
</script>
