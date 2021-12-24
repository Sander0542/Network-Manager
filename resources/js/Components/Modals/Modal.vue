<template>
    <teleport to="body">
        <div class="modal fade" tabindex="-1" :id="id" :aria-labelledby="id" aria-hidden="true">
            <div class="modal-dialog" :class="maxWidthClass">
                <slot></slot>
            </div>
        </div>
    </teleport>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    data() {
        return {
            bootstrapModal: null,
        };
    },
    props: {
        id: {
            type: String,
            required: true
        },
        maxWidth: {
            default: 'md'
        }
    },
    computed: {
        maxWidthClass() {
            return {
                'sm': 'modal-sm',
                'md': null,
                'lg': 'modal-lg',
                'xl': 'modal-xl',
            }[this.maxWidth]
        }
    },
    methods: {
        show() {
            this.bootstrapModal.show();
        },
        hide() {
            this.bootstrapModal.hide();
        },
    },
    mounted() {
        this.bootstrapModal = new bootstrap.Modal(document.getElementById(this.id));
    },
    unmounted() {
        this.bootstrapModal.hide();
    }
})
</script>
