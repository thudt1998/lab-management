<template>
    <mdb-container>
        <mdb-card wide>
            <div class="pl-3 pt-3">
                <button
                    class="btn btn-primary"
                    @click="addProject"
                >
                    <i class="fas fa-plus-circle"></i> Thêm
                </button>
            </div>
            <div class="margin-top style-data-table">
                <div class="margin-top font-size">
                    <strong>Danh sách project</strong>
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
                        <th class="th-sm" style="text-align: center">
                            <span class="font-weight-500">Tên project</span>
                        </th>
                        <th class="th-sm" style="text-align: center">
                            <span class="font-weight-500">Trạng thái</span>
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
                        <td style="width: 20%">
                            {{ project.id }}
                        </td>
                        <td style="width: 60%;text-align: center">
                            {{ project.name }}
                        </td>
                        <td style="width: 20%">
                            {{ project.date_start }}
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
                    v-show="students.length === 0"
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
    import {strings} from "../../strings";
    import {mdbCard, mdbContainer, mdbIcon, mdbInput} from "mdbvue";

    Vue.use(VueToast);
    export default {
        name: "ProjectComponent",
        components: {
            mdbCard,
            mdbContainer,
            mdbInput,
            mdbIcon
        },
        data() {
            return {
                messageNoData: strings.messageNoData
            };
        },
        created() {
            if (this.studentCreateSuccess) {
                Vue.$toast.success("<i class=\"far fa-check-circle\"></i>" + "   " + this.studentCreateSuccess,
                    {position: "top-right", duration: "10000"});
            }
            if (this.studentCreateFail) {
                Vue.$toast.error("<i class=\"far fa-times-circle\"></i>" + "   " + this.studentCreateFail,
                    {position: "top-right", duration: "10000"});
            }
        },
        props: {
            students: {
                type: Array,
                default: []
            },
            studentCreateSuccess: {
                type: String,
                default: ""
            },
            studentCreateFail: {
                type: String,
                default: ""
            }
        },
        methods: {
            addProject() {
                window.location.href = "/lecturers/projects/create";
            }
        }
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

    .notices .toast {
        margin-top: 50px;
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
</style>
