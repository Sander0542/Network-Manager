<template>
    <Link :href="'/'" class="d-flex justify-content-center mb-4">
        <application-logo width="64"/>
    </Link>
</template>

<script>
import {defineComponent} from 'vue'
import {Link} from '@inertiajs/inertia-vue3';
import ApplicationLogo from "@/Jetstream/ApplicationLogo";

export default defineComponent({
    components: {
        ApplicationLogo,
        Link,
    },
})
</script>
