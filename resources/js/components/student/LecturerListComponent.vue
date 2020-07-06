<template>
    <mdb-container>
        <mdb-card wide>
            <div class="margin-top style-data-table">
                <div class="margin-top font-size">
                    <h3 style="color: #661a00">Danh sách giảng viên</h3>
                </div>
                <div class="d-flex justify-content-start">
                    <div class="form-group">
                        <label for="email">Bộ môn</label>
                        <select
                            class="browser-default custom-select"
                            v-model="subject"
                        >
                            <option
                                v-for="subject in subjects"
                                :value="subject.id"
                                :key="subject.id"
                            >
                                {{subject.name}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-5">
                        <label for="name">Giảng viên</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="name"
                        />
                    </div>
                    <div class="form-group ml-5 mt-4">
                        <button class="btn btn-primary" @click="searchLecturer">Tìm kiếm</button>
                    </div>
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
                        >
                            <span class="font-weight-500">Họ tên</span>
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
                    v-show="lecturers.data.length === 0"
                    class="white text-center text-black-50"
                >
                    {{messageNoData}}
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
                                    v-model="Object(lecturer.subject).name"
                                    disabled
                                />
                            </div>
                            <div class="form-group">
                                <label for="subject">Projects:</label>
                                <ul
                                    style="max-height: 100px;overflow-y: auto; background-color: #e9ecef">
                                    <li v-for="project in lecturer.projects">{{project.name}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
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
    import axios from "axios";
    import Paging from "../common/Paging";

    Vue.use(VueToast);
    export default {
        name: "LecturerListComponent",
        components: {
            mdbCard,
            mdbContainer,
            mdbInput,
            mdbIcon,
            Paging
        },
        data() {
            return {
                messageNoData: strings.messageNoData,
                project: {},
                page: 1,
                lecturers: this.list,
                subject: "",
                name: "",
                lecturer: {},
            }
        },
        props: {
            list: {
                type: Object,
                default: {}
            },
            subjects: {
                type: Array,
                default: [],
            },
        },
        methods: {
            onClickRow(id) {
                this.lecturer = this.lecturers.data.filter(item => item.id === id)[0];
                $("#btnInfo").click();
            },
            changePage(page) {
                this.page = page;
                this.getListLecturer(true);
            },
            getListLecturer(isPaginator) {
                if (!isPaginator) {
                    this.page = 1;
                }
                axios.get("/students/lecturers", {
                    params: {
                        page: this.page,
                        subject: this.subject,
                        name: this.name
                    }
                }).then(res => {
                    if (res.data) {
                        this.lecturers = res.data.data;
                    }
                });
            },
            compareDate(dateFinish) {
                let newDateFinish = new Date(dateFinish);
                let today = new Date();
                if (newDateFinish.getTime() < today.getTime()) {
                    return "Đã hoàn thành";
                } else {
                    return "Chưa hoàn thành";
                }
            },
            searchLecturer: _.debounce(function () {
                this.getListLecturer();
            }, 100),
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

    .title {
        color: #661a00;
        font-size: 16px;
        font-weight: bold;
    }

    .value {
        font-weight: 400;
        font-size: 16px;
    }
</style>
