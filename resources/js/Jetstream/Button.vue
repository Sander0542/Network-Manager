<template>
    <button :type="type" class="btn text-uppercase" :class="colorClass">
        <slot></slot>
    </button>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    props: {
        type: {
            type: String,
            default: 'submit',
        },
        color: {
            type: String,
            default: 'dark'
        },
    },
    computed: {
        colorClass() {
            return {
                'primary': 'btn-primary',
                'secondary': 'btn-secondary',
                'success': 'btn-success',
                'danger': 'btn-danger',
                'warning': 'btn-warning',
                'info': 'btn-info',
                'light': 'btn-light',
                'dark': 'btn-dark',
                'link': 'btn-link',
            }[this.color]
        }
    }
})
</script>
