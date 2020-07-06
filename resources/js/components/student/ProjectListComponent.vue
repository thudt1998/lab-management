<template>
    <mdb-container>
        <mdb-card wide>
            <div class="margin-top style-data-table">
                <div class="margin-top font-size">
                    <h3 style="color: #661a00">Danh sách project</h3>
                </div>
                <div class="d-flex justify-content-start">
                    <div class="form-group">
                        <label for="email">Đề tài</label>
                        <select
                            class="browser-default custom-select"
                            v-model="topic"
                        >
                            <option
                                v-for="topic in topics"
                                :value="topic.id"
                                :key="topic.id"
                            >
                                {{topic.name}}
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
                        <button class="btn btn-primary" @click="searchProject">Tìm kiếm</button>
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
                            <span class="font-weight-500">Tên project</span>
                        </th>
                        <th class="th-sm">
                            <span class="font-weight-500">Giảng viên</span>
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
                        v-for="project in projects.data"
                        :key="project.id"
                        style="cursor: pointer"
                    >
                        <td style="width: 10%">
                            {{ project.id }}
                        </td>
                        <td style="width: 40%">
                            {{ project.name }}
                        </td>
                        <td style="width: 15%">
                            {{ Object(project.lecturer).name }}
                        </td>
                        <td style="width: 15%">
                            {{compareDate(project.date_finish)}}
                        </td>
                        <td style="width: 20%">
                            <button
                                class="btn btn-outline-primary pt-1 pb-1 pl-2 pr-2"
                                @click="onClickRow(project.id)"
                                style="margin-top: -4px;margin-bottom: -2px"
                            >
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <paging
                    :pagination="projects"
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
            <button id="btnInfoProject" style="display: none" data-toggle="modal" data-target="#modalInfoProject">
            </button>
            <div
                class="modal fade"
                id="modalInfoProject"
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
                                Thông tin project
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
                                            Tên project
                                        </td>
                                        <td class="value" style="width: 60%">
                                            {{ project.name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" style="width: 20%">
                                            Đề tài
                                        </td>
                                        <td class="value" style="width: 60%">
                                            <ul v-for="topic in project.topics" v-if="project.topics.length>0">
                                                <li>{{topic.name}}</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" style="width: 20%">
                                            Giảng viên
                                        </td>
                                        <td class="value" style="width: 60%">
                                            {{ Object(project.lecturer).name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" style="width: 20%">
                                            Số sinh viên
                                        </td>
                                        <td class="value" style="width: 60%">
                                            {{ Array(project.students).length }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" style="width: 20%">
                                            Phòng
                                        </td>
                                        <td class="value" style="width: 60%">
                                            {{ Object(Object(project.compartment).laboratory).name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" style="width: 20%">
                                            Ngăn
                                        </td>
                                        <td class="value" style="width: 60%">
                                            {{ Object(project.compartment).name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" style="width: 20%">
                                            Ngày bắt đầu
                                        </td>
                                        <td class="value" style="width: 60%">
                                            {{ project.date_start }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" style="width: 20%">
                                            Ngày kết thúc
                                        </td>
                                        <td class="value" style="width: 60%">
                                            {{ project.date_finish }}
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
    import Vue from "vue";
    import VueToast from "vue-toast-notification";
    import "vue-toast-notification/dist/theme-default.css";
    import {strings} from "../../strings";
    import {mdbCard, mdbContainer, mdbIcon, mdbInput} from "mdbvue";
    import axios from "axios";
    import Paging from "../common/Paging";

    Vue.use(VueToast);
    export default {
        name: "ListProjectsComponent",
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
                keyword: "",
                projects: this.list,
                topic: "",
                name: "",
            }
        },
        props: {
            list: {
                type: Object,
                default: {}
            },
            topics: {
                type: Array,
                default: [],
            },
        },
        methods: {
            onClickRow(id) {
                this.project = this.projects.data.filter(item => item.id === id)[0];
                $("#btnInfoProject").click();
            },
            changePage(page) {
                this.page = page;
                this.getListProjects(true);
            },
            getListProjects(isPaginator) {
                if (!isPaginator) {
                    this.page = 1;
                }
                axios.get("/students/projects", {
                    params: {
                        page: this.page,
                        topic: this.topic,
                        name: this.name
                    }
                }).then(res => {
                    if (res.data) {
                        this.projects = res.data.data;
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
            searchProject: _.debounce(function () {
                this.getListProjects();
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
