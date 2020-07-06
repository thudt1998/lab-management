<template>
    <mdb-container>
        <mdb-card wide>
            <div class="margin-top style-data-table">
                <div class="margin-top font-size">
                    <h3>Danh sách sinh viên</h3>
                </div>
                <div class="d-flex justify-content-end">
                    <mdb-input
                        v-model="keyword"
                        label="Tìm kiếm theo tên"
                        class="mb-0"
                        @change="searchStudent"
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
                            <span class="font-weight-500">Họ và tên</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="student in students.data"
                        :key="student.id"
                    >
                        <td style="width: 20%">
                            {{ student.id }}
                        </td>
                        <td style="width: 60%">
                            {{ student.name }}
                        </td>
                        <td style="width: 20%">
                            <button
                                class="btn btn-outline-primary pt-1 pb-1 pl-2 pr-2"
                                @click="onClickRow(student.id)"
                                style="margin-top: -4px;margin-bottom: -2px"
                            >
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <paging
                    :pagination="students"
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
            <button id="btnInfoStudent" style="display: none" data-toggle="modal" data-target="#modalInfoStudent">
            </button>
            <div
                class="modal fade"
                id="modalInfoStudent"
                tabindex="-1"
                role="dialog"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
                style="margin-top: 20vh"
            >
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4
                                class="modal-title"
                                style="color: #661a00"
                            >
                                Thông tin sinh viên
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
                        <div class="modal-body pr-4 pl-4">
                            <div class="form-group info" style="font-size: 18px">
                                <table
                                    class="table table-striped table-responsive-lg"
                                >
                                    <tr>
                                        <td class="title" style="width: 20%">
                                            Họ và tên
                                        </td>
                                        <td class="value" style="width: 60%">
                                            {{ student.name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" style="width: 20%">
                                            Email
                                        </td>
                                        <td class="value" style="width: 60%">
                                            {{student.email}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" style="width: 20%">
                                            Giảng viên tạo
                                        </td>
                                        <td class="value" style="width: 60%">
                                            {{ Object(student.lecturer).name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" style="width: 20%">
                                            Lớp
                                        </td>
                                        <td class="value" style="width: 60%">
                                            {{student.class}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" style="width: 20%">
                                            Project tham gia
                                        </td>
                                        <td class="value" style="width: 60%">
                                            <ul v-for="project in student.projects" v-if="student.projects.length>0">
                                                <li>{{project.name}}</li>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
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
        </mdb-card>
    </mdb-container>
</template>
<script>
    import "vue-toast-notification/dist/theme-default.css";
    import {strings} from "../strings";
    import {mdbCard, mdbContainer, mdbIcon, mdbInput} from "mdbvue";
    import Paging from "./common/Paging";
    import axios from "axios";

    export default {
        name: "ListStudentsComponent",
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
                student: {},
                students: this.list,
                keyword: "",
            }
        },
        props: {
            list: {
                type: Object,
                default: {},
            },
        },
        methods: {
            onClickRow(id) {
                this.student = this.students.data.filter(item => item.id === id)[0];
                $("#btnInfoStudent").click();
            },
            changePage(page) {
                this.page = page;
                this.getListStudents(true);
            },
            getListStudents(isPaginator) {
                if (!isPaginator) {
                    this.page = 1;
                }
                axios.get("/managers/get-students", {
                    params: {
                        page: this.page,
                        keyword: this.keyword
                    }
                }).then(res => {
                    if (res.data) {
                        this.students = res.data.data;
                    }
                });
            },
            searchStudent: _.debounce(function () {
                this.getListStudents();
            }, 1000),
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
