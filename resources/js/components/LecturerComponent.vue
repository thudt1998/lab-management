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
                    <h3 style="color: #661a00">Danh sách giảng viên</h3>
                </div>
                <div class="d-flex justify-content-end">
                    <mdb-input
                        v-model="keyword"
                        label="Tìm kiếm"
                        class="mb-0"
                        @change="searchLecturer"
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
                            <span class="font-weight-500">Email</span>
                        </th>
                        <th
                            class="th-sm"
                            @click="sortLecturers"
                        >
                            <mdb-icon
                                v-if="sort === 'ASC'"
                                icon="sort-up"
                            />
                            <mdb-icon
                                v-if="sort === 'DESC'"
                                icon="sort-down"
                            />
                            <span class="font-weight-500">Họ tên</span>
                        </th>
                        <th class="th-sm">
                            <span class="font-weight-500">Trạng thái</span>
                        </th>
                        <th class="th-sm"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="lecturer in lecturers.data"
                        :key="lecturer.id"
                    >
                        <td style="width: 10%">
                            {{ lecturer.id }}
                        </td>
                        <td style="width: 30%">
                            {{ lecturer.email }}
                        </td>
                        <td style="width: 30%">
                            {{ lecturer.name }}
                        </td>
                        <td class="text-center" style="width: 10%">
                            {{ lecturer.status ? "On" : "Off" }}
                        </td>
                        <td style="width: 20%">
                            <button
                                class="btn btn-outline-primary pt-1 pb-1 pl-2 pr-2"
                                @click="onClickRow(lecturer.id)"
                                style="margin-top: -4px;margin-bottom: -2px"
                            >
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <button
                                class="btn btn-outline-warning pt-1 pb-1 pl-2 pr-2"
                                @click="onClickRow(lecturer.id)"
                                style="margin-top: -4px;margin-bottom: -2px"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <paging
                    :pagination="lecturers"
                    :offset="2"
                    :per-page="10"
                    @paginate="changePage"
                />
                <div
                    v-show="lecturers.length === 0"
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
                            style="margin-left: 150px;color: #661a00"
                        >
                            Thêm giảng viên
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
                            <label for="name">Họ và tên</label>
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
                            <label for="email">Email</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="email"
                                :class="{'error-input':errorEmail}"
                            />
                            <span
                                v-if="errorEmail"
                                class="error-validate"
                            >
                                {{errorEmail}}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="subject">Bộ môn</label>
                            <select
                                class="browser-default custom-select"
                                v-model="subject"
                                :class="{'error-input':errorSubject}"
                            >
                                <option
                                    v-for="subject in subjects"
                                    :value="subject.id"
                                    :key="subject.id"
                                >
                                    {{subject.name}}
                                </option>
                            </select>
                            <span
                                v-if="errorSubject"
                                class="error-validate"
                            >
                                {{errorSubject}}
                            </span>
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
                            style="margin-left: 120px;color: #661a00"
                        >
                            Thông tin giảng viên
                        </h4>
                        <button
                            id="btnCloseModalInfo"
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
                            <label for="name">Họ và tên:</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="lecturer.name"
                                disabled
                            />
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="lecturer.email"
                                disabled
                            />
                        </div>
                        <div class="form-group">
                            <label for="subject">Bộ môn:</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="subjectInfo"
                                disabled
                            />
                        </div>
                        <div class="form-group">
                            <label for="subject">Số projects: {{lecturer.projects_count}}</label>
                            <ul v-if="lecturer.projects_count>0"
                                style="max-height: 100px;overflow-y: auto; background-color: #e9ecef">
                                <li v-for="project in lecturer.projects">{{project.name}}</li>
                            </ul>
                        </div>
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
                email: "",
                subject: "",
                errorName: "",
                errorEmail: "",
                errorSubject: "",
                isLoading: false,
                companiesData: {},
                page: 1,
                keyword: "",
                sort: "ASC",
                entry: 10,
                messageNoData: strings.messageNoData,
                lecturers: this.list,
                lecturer: {},
                subjectInfo: ""
            }
        },
        props: {
            list: {
                type: Object,
                default: []
            },
            subjects: {
                type: Array,
                default: []
            },
            lecturerCreateSuccess: {
                type: String,
                default: ""
            },
            lecturerCreateFail: {
                type: String,
                default: ""
            }
        },
        created() {
            if (this.lecturerCreateSuccess) {
                Vue.$toast.success("<i class=\"far fa-check-circle\"></i>" + "   " + this.lecturerCreateSuccess,
                    {position: "top-right", duration: "10000"});
            }
            if (this.lecturerCreateFail) {
                Vue.$toast.error("<i class=\"far fa-times-circle\"></i>" + "   " + this.lecturerCreateFail,
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
                    if (!this.email) {
                        this.errorEmail = strings.emailIsRequired;
                    } else {
                        this.errorEmail = "";
                    }
                    if (!this.subject) {
                        this.errorSubject = strings.subjectIsRequired;
                    } else {
                        this.errorSubject = "";
                    }
                } else {
                    this.addLecturer();
                }
            },
            addLecturer() {
                this.isLoading = true;
                axios.post('/managers/lecturers', {name: this.name, email: this.email, subject: this.subject})
                    .then(() => {
                        $('#btnCloseModal').click();
                        this.isLoading = false;
                        location.reload();
                    }).catch((error) => {
                    this.errorName = "";
                    this.errorEmail = "";
                    this.errorSubject = "";
                    let errors = error.response.data.errors;
                    if (errors["name"]) {
                        this.errorName = errors["name"][0];
                    }
                    if (errors["email"]) {
                        this.errorEmail = errors["email"][0];
                    }
                    if (errors["subject"]) {
                        this.errorSubject = errors["subject"][0];
                    }
                });
            },
            changePage(page) {
                this.page = page;
                this.getListLecturer(true);
            },
            getListLecturer(isPaginator) {
                if (!isPaginator) {
                    this.page = 1;
                }
                axios.get("/managers/lecturers", {
                    params: {
                        page: this.page,
                        keyword: this.keyword,
                        sort: this.sort,
                    }
                }).then(res => {
                    if (res.data) {
                        this.lecturers = res.data.data;
                    }
                });
            },
            searchLecturer: _.debounce(function () {
                this.getListLecturer();
            }, 1000),
            sortLecturers() {
                if (this.sort === "ASC") {
                    this.sort = "DESC";
                } else {
                    this.sort = "ASC";
                }
                this.getListLecturer(true);
            },
            onClickRow(id) {
                this.lecturer = this.lecturers.data.filter(item => item.id === id)[0];
                this.subjectInfo = this.lecturer.subject.name;
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
