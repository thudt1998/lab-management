<template>
    <mdb-container>
        <Loading
            :open="isLoading"
        />
        <mdb-card wide>
            <div class="pl-3 pt-3">
                <button
                    class="btn btn-primary"
                    data-toggle="modal"
                    data-target="#modalAdd"
                >
                    <i class="fas fa-plus-circle"></i> Thêm
                </button>
            </div>
            <div class="margin-top style-data-table">
                <div class="margin-top font-size">
                    <h3>Danh sách phòng</h3>
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
                        v-for="laboratory in laboratories"
                        :key="laboratory.id"
                        style="cursor: pointer"
                        title="Xem chi tiết"
                        @click="onclickRow(laboratory.id)"
                    >
                        <td style="width: 50%">
                            {{ laboratory.id }}
                        </td>
                        <td style="width: 50%">
                            {{ laboratory.name }}
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
                    v-show="laboratories.length === 0"
                    class="white text-center text-black-50"
                >
                    {{messageNoData}}
                </div>
            </div>
        </mdb-card>
        <div
            class="modal fade"
            id="modalAdd"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
            style="margin-top: 20vh"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4
                            class="modal-title"
                            style="margin-left: 150px"
                        >
                            Thêm phòng
                        </h4>
                        <button
                            id="btnCloseModal"
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Tên phòng</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="name"
                                :class="{'error-input':errorName}"
                            />
                            <span
                                v-if="errorName"
                                class="error-validate"
                            >
                                {{errorName}}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="location">Vị trí</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="location"
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="validateCreate"
                        >
                            Tạo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </mdb-container>
</template>
<script>
    import Vue from "vue";
    import axios from "axios";
    import Loading from "./common/Loading";
    import VueToast from "vue-toast-notification";
    import "vue-toast-notification/dist/theme-default.css";
    import {strings} from "../strings";
    import {mdbCard, mdbContainer, mdbIcon, mdbInput} from "mdbvue";

    Vue.use(VueToast);
    export default {
        name: "LecturerComponent",
        components: {
            mdbCard,
            mdbContainer,
            mdbInput,
            mdbIcon,
            Loading
        },
        data() {
            return {
                name: "",
                location: "",
                errorName: "",
                isLoading: false,
                pagination: {},
                companiesData: {},
                page: 1,
                keyword: "",
                sort: "ASC",
                sortBy: "company_id_3rd",
                entry: 10,
                messageNoData: strings.messageNoData,
            }
        },
        props: {
            laboratories: {
                type: Array,
                default: []
            },
            laboratoryCreateSuccess: {
                type: String,
                default: ""
            },
            laboratoryCreateFail: {
                type: String,
                default: ""
            }
        },
        created() {
            if (this.laboratoryCreateSuccess) {
                Vue.$toast.success("<i class=\"far fa-check-circle\"></i>" + "   " + this.laboratoryCreateSuccess,
                    {position: "top-right", duration: "10000"});
            }
            if (this.laboratoryCreateFail) {
                Vue.$toast.error("<i class=\"far fa-times-circle\"></i>" + "   " + this.laboratoryCreateFail,
                    {position: "top-right", duration: "10000"});
            }
        },
        methods: {
            validateCreate() {
                Vue.$toast.clear();
                if (!this.name) {
                    this.errorName = strings.nameIsRequired;
                } else {
                    this.errorName = "";
                    this.addLaboratory();
                }
            },
            addLaboratory() {
                this.isLoading = true;
                axios.post('/managers/laboratories', {name: this.name})
                    .then(() => {
                        $('#btnCloseModal').click();
                        this.isLoading = false;
                        location.reload();
                    }).catch((error) => {
                    this.errorName = "";
                    let errors = error.response.data.errors;
                    if (errors["name"]) {
                        this.errorName = errors["name"][0];
                    }
                });
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
