<template>
    <mdb-container>
        <mdb-card wide>
            <div class="margin-top style-data-table">
                <div class="margin-top font-size">
                    <h3>Danh sách project</h3>
                </div>
                <div class="d-flex justify-content-end">
                    <mdb-input
                        v-model="keyword"
                        label="Tìm kiếm"
                        class="mb-0"
                        @change="searchCompanies"
                    />
                </div>
                <table
                    class="table table-striped table-responsive-lg"
                >
                    <thead>
                    <tr>
                        <th
                            class="th-sm"
                            @click="sortCompanies('company_id_3rd')"
                        >
                            <mdb-icon
                                v-if="sortBy === 'company_id_3rd' && sort === 'ASC'"
                                icon="sort-up"
                            />
                            <mdb-icon
                                v-if="sortBy === 'company_id_3rd' && sort === 'DESC'"
                                icon="sort-down"
                            />
                            <span class="font-weight-500">ID</span>
                        </th>
                        <th class="th-sm">
                            <span class="font-weight-500">Tên</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="project in projects"
                        :key="project.id"
                        style="cursor: pointer"
                        title="Xem chi tiết"
                        @click="onclickRow(project.id)"
                    >
                        <td style="width: 50%">
                            {{ project.id }}
                        </td>
                        <td style="width: 50%">
                            {{ project.name }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <paging
                    :pagination="pagination"
                    :offset="2"
                    :per-page="10"
                    @paginate="changePage"
                />
                <div
                    v-show="projects.length === 0"
                    class="white text-center text-black-50"
                >
                    {{messageNoData}}
                </div>
            </div>
        </mdb-card>
    </mdb-container>
</template>
<script>
    import Vue from "vue";
    import VueToast from "vue-toast-notification";
    import "vue-toast-notification/dist/theme-default.css";
    import {strings} from "../strings";
    import {mdbCard, mdbContainer, mdbIcon, mdbInput} from "mdbvue";

    Vue.use(VueToast);
    export default {
        name: "ListProjectsComponent",
        components: {
            mdbCard,
            mdbContainer,
            mdbInput,
            mdbIcon
        },
        data() {
            return {
                messageNoData: strings.messageNoData,
            }
        },
        props: {
            projects: {
                type: Array,
                default: []
            },
        },
    }
</script>
<style scoped>
    .md-menu-content {
        z-index: 99999 !important;
    }

    label {
        font-size: 1.2rem;
        font-weight: 400;
    }

    .error-validate {
        font-style: italic;
        font-size: 13px;
        color: red;
    }

    .notices .toast {
        margin-top: 50px;
    }

    .error-input {
        border: 1px solid #e3342f;
    }

    .margin-top {
        margin-top: 10px;
        padding: 5px;
    }

    .style-data-table {
        height: 100%;
        width: 100%;
        border: 1px #3ace20;
        padding: 20px;
    }

    table.table th, table.table td {
        padding-top: 0.5rem;
        padding-bottom: 0.4rem;
    }

    table.table td a {
        color: #212529 !important;
        text-decoration: none !important;
    }

    .font-size {
        font-size: 1.3rem;
    }

    .font-weight-500 {
        font-weight: 500;
    }

    .entry {
        margin-top: 0.7rem;
    }
</style>
