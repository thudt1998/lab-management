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
                    <h3 style="color: #661a00">Danh sách ngăn phòng</h3>
                </div>
                <div class="d-flex justify-content-end">
                    <mdb-input
                        v-model="keyword"
                        label="Tìm theo phòng"
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
                        >
                            <span class="font-weight-500">ID</span>
                        </th>
                        <th class="th-sm">
                            <span class="font-weight-500">Phòng</span>
                        </th>
                        <th class="th-sm">
                            <span class="font-weight-500">Tên ngăn</span>
                        </th>
                        <th class="th-sm">
                            <span class="font-weight-500">Trạng thái</span>
                        </th>
                        <th class="th-sm">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="compartment in compartments.data"
                        :key="compartment.id"
                    >
                        <td style="width: 10%">
                            {{ compartment.id }}
                        </td>
                        <td style="width: 20%">
                            {{ compartment.laboratory.name }}
                        </td>
                        <td style="width: 30%">
                            {{ compartment.name }}
                        </td>
                        <td style="width: 10%">
                            {{ compartment.projects.length > 0 ?"Đầy":"Trống" }}
                        </td>
                        <td style="width: 30%">
                            <button
                                class="btn btn-outline-primary pt-1 pb-1 pl-2 pr-2"
                                style="margin-top: -4px;margin-bottom: -2px"
                                @click="onClickRow(compartment.id)"
                            >
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <button
                                class="btn btn-outline-warning pt-1 pb-1 pl-2 pr-2"
                                style="margin-top: -4px;margin-bottom: -2px"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                            <button
                                class="btn btn-outline-danger pt-1 pb-1 pl-2 pr-2"
                                style="margin-top: -4px;margin-bottom: -2px"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <paging
                    :pagination="compartments"
                    :offset="2"
                    :per-page="10"
                    @paginate="changePage"
                />
                <div
                    v-show="compartments.data.length === 0"
                    class="white text-center text-black-50"
                >
                    {{messageNoData}}
                </div>
            </div>
        </mdb-card>
        <button id="btnInfo" style="display: none" data-toggle="modal" data-target="#modalInfo"></button>
        <div
            class="modal fade"
            id="modalInfo"
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
                            style="margin-left: 130px; color: #661a00"
                        >
                            Thông tin ngăn phòng
                        </h4>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pl-4 pr-4">
                        <div class="form-group">
                            <label for="laboratory">Phòng</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="Object(compartment.laboratory).name"
                                disabled
                            />
                        </div>
                        <div class="form-group">
                            <label for="name">Tên ngăn phòng</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="compartment.name"
                                disabled
                            />
                        </div>
                        <div class="form-group">
                            <label for="tables">Số bàn</label>
                            <input
                                type="number"
                                class="form-control"
                                v-model="compartment.tables"
                                min="0"
                                disabled
                            />
                        </div>
                        <div class="form-group">
                            <label for="chairs">Số ghế</label>
                            <input
                                type="number"
                                class="form-control"
                                v-model="compartment.chairs"
                                min="0"
                                disabled
                            />
                        </div>
                        <div class="form-group">
                            <label for="computers">Số máy tính</label>
                            <input
                                type="number"
                                class="form-control"
                                v-model="compartment.computers"
                                min="0"
                                disabled
                            />
                        </div>
                        <div class="form-group">
                            <label>Project đang hoạt động</label>
                            <ul v-for="project in compartment.projects">
                                <li style="font-size: 1rem; font-style: italic">{{project.name}}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-primary"
                            data-dismiss="modal"
                        >
                            Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
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
                            style="margin-left: 130px; color: #661a00"
                        >
                            Thêm ngăn phòng
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
                    <div class="modal-body pl-4 pr-4">
                        <div class="form-group">
                            <label for="laboratory">Phòng</label>
                            <select
                                class="browser-default custom-select"
                                v-model="laboratory"
                                :class="{'error-input':errorLaboratory}"
                            >
                                <option
                                    v-for="laboratory in laboratories"
                                    :value="laboratory.id"
                                    :key="laboratory.id"
                                >
                                    {{laboratory.name}}
                                </option>
                            </select>
                            <span
                                v-if="errorLaboratory"
                                class="error-validate"
                            >
                                {{errorLaboratory}}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="name">Tên ngăn phòng</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="name"
                            />
                            <span
                                v-if="errorName"
                                class="error-validate"
                            >
                                {{errorName}}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="tables">Số bàn</label>
                            <input
                                type="number"
                                class="form-control"
                                v-model="tables"
                                min="0"
                            />
                        </div>
                        <div class="form-group">
                            <label for="chairs">Số ghế</label>
                            <input
                                type="number"
                                class="form-control"
                                v-model="chairs"
                                min="0"
                            />
                        </div>
                        <div class="form-group">
                            <label for="computers">Số máy tính</label>
                            <input
                                type="number"
                                class="form-control"
                                v-model="computers"
                                min="0"
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
    import Paging from "./common/Paging";

    Vue.use(VueToast);
    export default {
        name: "CompartmentComponent",
        components: {
            mdbCard,
            mdbContainer,
            mdbInput,
            mdbIcon,
            Loading,
            Paging
        },
        data() {
            return {
                name: "",
                laboratory: "",
                errorName: "",
                errorLaboratory: "",
                isLoading: false,
                page: 1,
                keyword: "",
                sort: "ASC",
                sortBy: "company_id_3rd",
                entry: 10,
                messageNoData: strings.messageNoData,
                compartments: this.list,
                tables: 0,
                chairs: 0,
                computers: 0,
                compartment: {},
            }
        },
        props: {
            list: {
                type: Object,
                default: {},
            },
            laboratories: {
                type: Array,
                default: []
            },
            compartmentCreateSuccess: {
                type: String,
                default: ""
            },
            compartmentCreateFail: {
                type: String,
                default: ""
            }
        },
        created() {
            if (this.compartmentCreateSuccess) {
                Vue.$toast.success("<i class=\"far fa-check-circle\"></i>" + "   " + this.compartmentCreateSuccess,
                    {position: "top-right", duration: "10000"});
            }
            if (this.compartmentCreateFail) {
                Vue.$toast.error("<i class=\"far fa-times-circle\"></i>" + "   " + this.compartmentCreateFail,
                    {position: "top-right", duration: "10000"});
            }
        },
        methods: {
            validateCreate() {
                Vue.$toast.clear();
                if (!this.name || !this.email || !this.subject) {
                    if (!this.name) {
                        this.errorName = strings.nameIsRequired;
                    } else {
                        this.errorName = "";
                    }
                } else {
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
            },
            changePage(page) {
                this.page = page;
                this.getListCompartment(true);
            },
            getListCompartment(isPaginator) {
                if (!isPaginator) {
                    this.page = 1;
                }
                axios.get("/managers/compartments", {
                    params: {
                        page: this.page,
                        keyword: this.keyword
                    }
                }).then(res => {
                    if (res.data) {
                        this.compartments = res.data.data;
                    }
                });
            },
            searchCompanies: _.debounce(function () {
                this.getListCompartment();
            }, 1000),
            onClickRow(id) {
                this.compartment = this.compartments.data.filter(compartment => compartment.id === id)[0];
                $('#btnInfo').click();
            },
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
