<template>
    <Link :href="href" class="btn btn-dark text-uppercase">
        <slot></slot>
    </Link>
</template>

<script>
import {defineComponent} from 'vue'
import {Link} from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        Link
    },
    props: {
        href: {
            type: String,
        },
    }
})
</script>
