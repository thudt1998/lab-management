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
                    <h3 style="color: #661a00">Danh sách phòng</h3>
                </div>
                <table
                    class="table table-striped table-responsive-lg mt-3"
                >
                    <thead>
                    <tr>
                        <th class="th-sm">
                            <span class="font-weight-500">ID</span>
                        </th>
                        <th class="th-sm">
                            <span class="font-weight-500">Tên</span>
                        </th>
                        <th class="th-sm">
                            <span class="font-weight-500">Vị trí</span>
                        </th>
                        <th class="th-sm">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="laboratory in laboratories.data"
                        :key="laboratory.id"
                    >
                        <td style="width: 10%">
                            {{ laboratory.id }}
                        </td>
                        <td style="width: 35%">
                            {{ laboratory.name }}
                        </td>
                        <td style="width: 35%">
                            {{ laboratory.location }}
                        </td>
                        <td style="width: 20%">
                            <button
                                class="btn btn-outline-warning pt-1 pb-1 pl-2 pr-2"
                                @click="handleUpdate(laboratory.id)"
                                style="margin-top: -4px;margin-bottom: -2px"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                            <button
                                class="btn btn-outline-danger pt-1 pb-1 pl-2 pr-2"
                                style="margin-top: -4px;margin-bottom: -2px"
                                @click="handleDelete(laboratory.id)"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
<!--                <paging-->
<!--                    :pagination="laboratories"-->
<!--                    :offset="2"-->
<!--                    :per-page="10"-->
<!--                    @paginate="changePage"-->
<!--                />-->
<!--                <div-->
<!--                    v-show="laboratories.length === 0"-->
<!--                    class="white text-center text-black-50"-->
<!--                >-->
<!--                    {{messageNoData}}-->
<!--                </div>-->
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
                            style="margin-left: 150px;color: #661a00"
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
                    <div class="modal-body pr-4 pl-4">
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
        <button id="btnUpdate" style="display: none" data-toggle="modal" data-target="#modalUpdate"></button>
        <div
            class="modal fade"
            id="modalUpdate"
            tabindex="-1"
            role="dialog"
            aria-hidden="true"
            style="margin-top: 20vh"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4
                            class="modal-title"
                            style="margin-left: 150px;color: #661a00"
                        >
                            Cập nhật phòng
                        </h4>
                        <button
                            id="btnCloseModalUpdate"
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pr-4 pl-4">
                        <div class="form-group">
                            <label for="name">Tên phòng</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="name"
                                :class="{'error-input':errorNameUpdate}"
                            />
                            <span
                                v-if="errorNameUpdate"
                                class="error-validate"
                            >
                                {{errorNameUpdate}}
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
                            @click="update"
                        >
                            Cập nhật
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <button id="btnDelete" style="display: none" data-toggle="modal" data-target="#modalDelete"></button>
        <div
            class="modal fade"
            id="modalDelete"
            tabindex="-1"
            role="dialog"
            aria-hidden="true"
            style="margin-top: 20vh"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4
                            class="modal-title"
                            style="margin-left: 150px;color: #661a00"
                        >
                            Xóa phòng
                        </h4>
                        <button
                            id="btnCloseDelete"
                            type="button"
                            class="close"
                            data-dismiss="modal"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pr-4 pl-4">
                        <h6>Bạn có thực sự muốn xóa phòng?</h6>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-primary"
                            data-dismiss="modal"
                        >
                            Cancel
                        </button>
                        <button
                            type="button"
                            @click="deleteLab"
                            class="btn btn-danger"
                        >
                            Xóa
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
        name: "LecturerComponent",
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
                location: "",
                errorName: "",
                isLoading: false,
                pagination: {},
                companiesData: {},
                page: 1,
                messageNoData: strings.messageNoData,
                laboratories: this.list,
                laboratory: {},
                errorNameUpdate: "",
            }
        },
        props: {
            list: {
                type: Object,
                default: [],
            },
            laboratoryCreateSuccess: {
                type: String,
                default: "",
            },
            laboratoryCreateFail: {
                type: String,
                default: "",
            },
            laboratoryUpdateSuccess: {
                type: String,
                default: "",
            },
            laboratoryUpdateFail: {
                type: String,
                default: "",
            },
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
            if (this.laboratoryUpdateSuccess) {
                Vue.$toast.success("<i class=\"far fa-check-circle\"></i>" + "   " + this.laboratoryUpdateSuccess,
                    {position: "top-right", duration: "10000"});
            }
            if (this.laboratoryUpdateFail) {
                Vue.$toast.error("<i class=\"far fa-times-circle\"></i>" + "   " + this.laboratoryUpdateFail,
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
                axios.post('/managers/laboratories', {name: this.name, location: this.location})
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
                this.getListLaboratory(true);
            },
            getListLaboratory(isPaginator) {
                if (!isPaginator) {
                    this.page = 1;
                }
                axios.get("/managers/laboratories", {
                    params: {
                        page: this.page,
                    }
                }).then(res => {
                    if (res.data) {
                        this.laboratories = res.data.data;
                    }
                });
            },
            handleUpdate(id) {
                this.errorNameUpdate = "";
                this.laboratory = this.laboratories.data.filter(item => item.id === id)[0];
                this.name = this.laboratory.name;
                this.location = this.laboratory.location;
                $('#btnUpdate').click();
            },
            update() {
                this.isLoading = true;
                axios.put(`/managers/laboratories/${this.laboratory.id}`, {name: this.name, location: this.location})
                    .then(() => {
                        $('#btnCloseModalUpdate').click();
                        this.isLoading = false;
                        location.reload();
                    }).catch((error) => {
                    this.errorNameUpdate = "";
                    let errors = error.response.data.errors;
                    if (errors["name"]) {
                        this.errorNameUpdate = errors["name"][0];
                    }
                    this.isLoading = false;
                });
            },
            handleDelete(id) {
                this.laboratory = this.laboratories.data.filter(item => item.id === id)[0];
                $('#btnDelete').click();
            },
            deleteLab() {
                this.isLoading = true;
                axios.delete(`/managers/laboratories/${this.laboratory.id}`)
                    .then((res) => {
                        $('#btnCloseDelete').click();
                        this.isLoading = false;
                        if (res.data.error === true) {
                            Vue.$toast.error("<i class=\"far fa-times-circle\"></i>" + "   " + "Không thể xóa!",
                                {position: "top-right", duration: "10000"});
                        }else {
                            location.reload();
                        }
                    }).catch((error) => {
                    this.isLoading = false;
                });
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
