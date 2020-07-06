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
                    <h3>Danh sách project</h3>
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
                            <!--                            <button-->
                            <!--                                class="btn btn-outline-warning pt-1 pb-1 pl-2 pr-2"-->
                            <!--                                @click="onClickRow(project.id)"-->
                            <!--                                style="margin-top: -4px;margin-bottom: -2px"-->
                            <!--                            >-->
                            <!--                                <i class="fas fa-edit"></i>-->
                            <!--                            </button>-->
                            <button
                                class="btn btn-outline-danger pt-1 pb-1 pl-2 pr-2"
                                @click="handleDelete(project.id)"
                                style="margin-top: -4px;margin-bottom: -2px"
                                v-if="project.lecturer.id===user.id"
                            >
                                <i class="fas fa-trash"></i>
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
                                <h6>Bạn có thực sự muốn xóa project?</h6>
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
                                    @click="deleteProject"
                                    class="btn btn-danger"
                                >
                                    Xóa
                                </button>
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
        name: "ProjectComponent",
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
                projects: this.list,
                project: {},
            };
        },
        created() {
        },
        props: {
            list: {
                type: Object,
                default: {},
            },
            user:{
                type: Object,
                default: {},
            },
        },
        methods: {
            addProject() {
                window.location.href = "/lecturers/projects/create";
            },
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
                axios.get("/lecturers/projects", {
                    params: {
                        page: this.page
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
            }, 1000),
            handleDelete(id) {
                this.project = this.projects.data.filter(item => item.id === id)[0];
                $('#btnDelete').click();
            },
            deleteProject(){
                axios.delete(`/lecturers/projects/${this.project.id}`)
                    .then((res) => {
                        $('#btnCloseDelete').click();
                        if (res.data.error === true) {
                            Vue.$toast.error("<i class=\"far fa-times-circle\"></i>" + "   " + "Không thể xóa!",
                                {position: "top-right", duration: "10000"});
                        }else {
                            location.reload();
                        }
                    }).catch((error) => {
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
