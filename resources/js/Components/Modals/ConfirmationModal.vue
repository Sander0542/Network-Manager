<template>
    <modal ref="modal" :id="id" :max-width="maxWidth">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <slot name="title"/>
                </h5>
            </div>
            <div class="modal-body">
                <div v-show="form.errors.alert" class="alert alert-danger" role="alert">
                    {{ form.errors.alert }}
                </div>
                <slot/>
            </div>
            <div class="modal-footer bg-light">
                <button v-on:click="$emit('cancelled')" type="button" class="btn btn-secondary">Cancel</button>
                <button v-on:click="$emit('confirmed')" type="button" class="btn btn-danger" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Confirm
                </button>
            </div>
        </div>
    </modal>
</template>

<script>
import {defineComponent} from 'vue'
import Modal from './Modal.vue'

export default defineComponent({
    components: {
        Modal,
    },
    props: {
        id: {
            type: String,
            required: true
        },
        form: {
            type: Object,
            required: true
        },
        maxWidth: {
            type: String
        },
    },
    emits: [
        'confirmed',
        'cancelled',
    ],
    methods: {
        show() {
            this.$refs.modal.show();
        },
        hide() {
            this.$refs.modal.hide();
        }
    }
})
</script>
