<template>
    <div>
        <a
            class="dropdown-toggle"
            id="btnDropdown"
            data-toggle="dropdown"
            style="position: fixed; top: 10px; right: 18px; z-index: 9999; font-size: 20px"
        >
            <i class="fas fa-bell">
            </i>
        </a>
        <span class="badge badge-danger" style="position: fixed; top: 5px; right: 12px; z-index: 9999; font-size: 10px">{{this.notifications.length}}</span>
        <div class="dropdown-menu pt-0 pb-0" style="margin-top: -60px; z-index: 10000; margin-right: 20px">
            <span
                v-for="notification in notifications"
                class="dropdown-item"
                @click="clickRow(notification.id)"
                style="cursor: pointer"
            >
                {{notification.project.name}}
            </span>
        </div>
        <button id="btnInfo" style="display: none" data-toggle="modal" data-target="#modalInfo">
        </button>
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
                            style="color: #661a00"
                        >
                            Yêu cầu cập nhật cơ sở vật chất
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
                        <div class="form-group">
                            Tên project: {{project.name}}
                        </div>
                        <div class="form-group">
                            Bộ môn: {{project.name}}
                        </div>
                        <div class="form-group">
                            Giảng viên: {{Object(project.lecturer).name}}
                        </div>
                        <div class="form-group">
                            Số sinh viên: {{Array(project.students).length}}
                        </div>
                        <div class="form-group">
                            Số bàn: {{notification.tables}}
                        </div>
                        <div class="form-group">
                            Số ghế: {{notification.chairs}}
                        </div>
                        <div class="form-group">
                            Số máy tính: {{notification.computers}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click=""
                        >
                            Cập nhật
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "NotificationComponent",
        created() {
            axios.get('/managers/get-notification')
                .then(res => {
                    this.notifications = res.data.notifications;
                }).catch(err => {
                    console.log(err);
                }
            );
        },
        data() {
            return {
                'notifications': [],
                'list': [],
                notification: {},
                project: {},
            }
        },
        methods: {
            clickRow(id) {
                this.notification = this.notifications.filter(item => item.id === id)[0];
                this.project = this.notification.project;
                console.log(this.project);
                $("#btnInfo").click();
            }
        }
    }
</script>

<style scoped>
    .dropdown-toggle::after {
        display: none;
    }

    .dropdown-toggle::before {
        display: none;
    }

    .dropdown-item:hover {
        color: #ffffff;
        background-color: #f5805f;
    }
</style>
