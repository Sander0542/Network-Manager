<template>
    <app-layout title="Add Network">
        <template #header>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <Link :href="route('networks.index')">Networks</Link>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </nav>
        </template>

        <div class="row">
            <div class="col-6">
                <div class="card p-0">
                    <div class="card-body">
                        <div v-show="form.errors.alert" class="alert alert-danger" role="alert">
                            {{ form.errors.alert }}
                        </div>
                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <jet-label for="storeNetworkName" value="Name"/>
                                <jet-input required id="storeNetworkName" type="text" v-model="form.name" :class="{ 'is-invalid': form.errors.name }" autocomplete="network-name"/>
                                <jet-input-error :message="form.errors.name"/>
                            </div>
                            <div class="mb-3">
                                <jet-label for="storeNetworkRange" value="Range"/>
                                <jet-input required id="storeNetworkRange" type="text" v-model="form.range" :class="{ 'is-invalid': form.errors.range }" autocomplete="network-range" placeholder="0.0.0.0/0"/>
                                <jet-input-error :message="form.errors.range"/>
                            </div>
                            <jet-button>Add</jet-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
import {defineComponent} from "vue"
import {Link} from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue"
import LinkButton from "@/Components/LinkButton";
import JetButton from "@/Jetstream/Button";
import JetInputError from "@/Jetstream/InputError";
import JetInput from "@/Jetstream/Input";
import JetLabel from "@/Jetstream/Label";

export default defineComponent({
    components: {
        AppLayout,
        JetButton,
        JetInputError,
        JetInput,
        JetLabel,
        Link,
        LinkButton,
    },
    props: {
        networks: Array
    },
    data() {
        return {
            form: this.$inertia.form({
                name: null,
                range: null,
            }),
        };
    },
    methods: {
        submit() {
            this.form.post(route('networks.store'), {
                preserveScroll: true,
                preserveState: true,
            });
        }
    }
});
</script>
