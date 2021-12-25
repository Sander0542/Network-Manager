<template>
    <app-layout title="About">
        <template #header>
            <h2 class="h4 font-weight-bold">
                About
            </h2>
        </template>

        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Application</h5>
                        <table class="table table-borderless">
                            <tr v-for="(information, title) in application.about">
                                <th>{{ title }}</th>
                                <td v-if=" typeof information == 'object'" v-for="item in information">{{ item }}</td>
                                <td v-else>{{ information }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Versions</h5>
                        <table class="table table-borderless">
                            <tr v-for="(version, type) in application.versions">
                                <th>{{ type }}</th>
                                <td>{{ version }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">PHP Extensions</h5>
                        <table class="table table-borderless">
                            <tr v-for="(version, extension) in application.extensions">
                                <th>{{ extension }}</th>
                                <td>{{ version }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">NPM Packages</h5>
                        <table class="table table-borderless">
                            <tr v-for="(version, library) in application.libraries.npm">
                                <th>{{ library }}</th>
                                <td>{{ version }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="card-title m-0">Composer Packages</h5>
                    </div>
                    <ul class="list-group">
                        <li v-for="library in application.libraries.composer" class="list-group-item d-flex justify-content-between align-items-center border-0 border-bottom">
                            <div class="me-auto">
                                <div class="fw-bold">{{ library.name }}</div>
                                {{ library.description }}
                            </div>
                            <span v-for="license in library.licenses" class="badge bg-success rounded-pill me-1">{{ license }}</span>
                            <span class="badge bg-success rounded-pill">{{ library.version }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
import {defineComponent} from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"

export default defineComponent({
    components: {
        AppLayout,
    },
    props: {
        application: Object
    }
});
</script>
