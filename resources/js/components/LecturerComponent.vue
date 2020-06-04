<template>
    <div>
        <Loading
            :open="isLoading"
            is-full-page="true"
        />
        <div>
            <button
                class="btn btn-primary"
                data-toggle="modal"
                data-target="#modalAdd"
            >
                <i class="fas fa-plus-circle"></i> Thêm
            </button>
        </div>
        <div v-if="lecturers.length<=0">
            KhÔNG CÓ DỮ LIỆU
        </div>
        <ul
            v-else
        >
            <li v-for="lecturer in lecturers"
                :key="lecturer.id"
            >
                {{lecturer.name}}
            </li>
        </ul>
        <div
            class="modal fade"
            id="modalAdd"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
            style="margin-top: 25vh"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5
                            class="modal-title"
                            style="margin-left: 150px"
                        >
                            Thêm giảng viên
                        </h5>
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
                            <label for="name">Họ và tên</label>
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
                            <label for="email">Email</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="email"
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
                            @click="addLecturer"
                        >
                            Tạo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from "vue";
    import axios from "axios";
    import Loading from "./common/Loading";
    import VueToast from "vue-toast-notification";
    import "vue-toast-notification/dist/theme-default.css";

    Vue.use(VueToast);
    export default {
        name: "LecturerComponent",
        components: {
            Loading
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
            }
        },
        props: {
            lecturers: {
                type: Array,
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
            addLecturer() {
                this.isLoading = true;
                $('#btnCloseModal').click();
                axios.post('/managers/lecturers', {name: this.name, email: this.email, subject: this.subject})
                    .then(() => {
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
                }).finally(() => {
                    // this.isLoading = false;
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
</style>
