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
        <span class="badge badge-danger" style="position: fixed; top: 5px; right: 9px; z-index: 9999; font-size: 10px">{{this.notifications.length}}</span>
        <div class="dropdown-menu pt-0 pb-0"
             style="margin-top: -60px; z-index: 10000; margin-right: 20px;max-height: 200px;overflow-y: auto">
            <span
                v-for="notification in notifications"
                class="dropdown-item"
                @click="clickRow(notification.id)"
                style="cursor: pointer"
            >
                {{notification.project.name}}
            </span>
        </div>
        <button id="btnInfoNotification" style="display: none" data-toggle="modal" data-target="#modalInfoNotification">
        </button>
        <div
            class="modal fade"
            id="modalInfoNotification"
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
                            <h6 class="font-italic" style="font-size: 18px;color: #661a00;font-weight: bold">Thông tin
                                project:</h6>
                            <ul style="font-size: 16px">
                                <li><span class="title">Tên project: </span>{{project.name}}</li>
                                <li><span class="title">Giảng viên: </span>{{Object(project.lecturer).name}}</li>
                                <li><span class="title">Số sinh viên: </span>{{Array(project.students).length}}</li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <h6 class="font-italic" style="font-size: 18px;color: #661a00;font-weight: bold">Yêu
                                cầu:</h6>
                            <ul style="font-size: 16px">
                                <li><span class="title">Số bàn: </span>{{notification.tables}}</li>
                                <li><span class="title">Số ghế: </span>{{notification.chairs}}</li>
                                <li><span class="title">Số máy tính: </span>{{notification.computers}}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="updateNotification"
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
            Echo.channel("new-message").listen(".new-notification", (data) => {
                this.notifications.push(data.data);
            });
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
                notifications: [],
                notification: {},
                project: {},
            }
        },
        methods: {
            clickRow(id) {
                this.notification = this.notifications.filter(item => item.id === id)[0];
                this.project = this.notification.project;
                $("#btnInfoNotification").click();
            },
            updateNotification() {
                axios.put(`/managers/message/${this.project.id}`,this.notification).then(res => {
                    if (res.data.error === false) {
                        location.reload();
                    }
                }).catch(err => {
                    console.log(err);
                });
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

    .dropdown-item {
        padding: 10px;
    }

    .title {
        font-weight: bold;
    }

    ul li {
        padding: 2px;
    }
</style>
