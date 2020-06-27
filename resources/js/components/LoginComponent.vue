<template>
    <div>
        <div>
            <section class="form-elegant mt-5">
                <mdb-container>
                    <mdb-row>
                        <mdb-col
                            col="1"
                            sm="2"
                            md="3"
                            lg="3"
                            xl="3"
                        />
                        <mdb-col
                            col="10"
                            sm="8"
                            md="6"
                            lg="6"
                            xl="6"
                        >
                            <mdb-card style="margin-top: 5vh; border: 0; border-radius: 0">
                                <mdb-card-body class="mx-4 pl-1 pr-1 pt-5 pb-5">
                                    <div class="text-center">
                                        <h3 class="dark-grey-text mb-5 font-weight-bold title-login">
                                            Đăng nhập vào hệ thống
                                        </h3>
                                    </div>
                                    <form
                                        class="mr-4 ml-4"
                                        @submit.prevent="submit"
                                    >
                                        <md-field
                                            :class="(errorEmail||errorSystem) && 'md-invalid'"
                                        >
                                            <label class="label">Email</label>
                                            <md-input
                                                id="email"
                                                v-model="email"
                                                type="text"
                                                name="email"
                                                autocomplete="new-password"
                                            />
                                            <span
                                                v-if="errorEmail"
                                                class="md-error"
                                                style="font-size: 12px"
                                            >
                                                {{ errorEmail }}
                                            </span>
                                        </md-field>
                                        <md-field
                                            :class="(errorPassword||errorSystem) && 'md-invalid'"
                                        >
                                            <label class="label">Mật khẩu</label>
                                            <md-input
                                                id="password"
                                                v-model="password"
                                                type="password"
                                                name="password"
                                                autocomplete="new-password"
                                            />
                                            <span
                                                v-if="errorPassword"
                                                class="md-error"
                                                style="font-size: 12px"
                                            >
                                                {{ errorPassword }}
                                            </span>
                                        </md-field>
                                        <p
                                            v-if="errorSystem"
                                            class="text-danger"
                                            style="font-size: 12px"
                                        >
                                            {{ errorSystem }}
                                        </p>
                                        <span
                                            class="forgotPassword"
                                            v-if="url!=='/managers/login'"
                                            data-toggle="modal"
                                            data-target="#modalForgotPassword"
                                        >
                                            Quên mật khẩu?
                                        </span>
                                        <div class="text-center mb-3" :class="url!=='/managers/login'?'mt-3':'mt-5'">
                                            <button
                                                type="submit"
                                                class="btn btn-primary"
                                                style="width:100%; margin-left: -2px"
                                            >
                                                Đăng nhập
                                            </button>
                                        </div>
                                    </form>
                                </mdb-card-body>
                            </mdb-card>
                        </mdb-col>
                    </mdb-row>
                </mdb-container>
                <div class="modal fade" id="modalForgotPassword" tabindex="-1" role="dialog"
                     aria-labelledby="modalForgotPassword"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="exampleModalLabel">Khôi phục mật khẩu</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="font-size: 20px">
                                <form
                                    class="mr-2 ml-2"
                                >
                                    <md-field
                                        :class="error && 'md-invalid'"
                                    >
                                        <label class="label">Email</label>
                                        <md-input
                                            v-model="emailForgot"
                                            type="text"
                                            autocomplete="new-password"
                                        />
                                        <span
                                            v-if="error"
                                            class="md-error"
                                            style="font-size: 12px"
                                        >
                                            {{ error }}
                                        </span>
                                    </md-field>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button
                                    class="btn btn-warning"
                                    @click="forgotPassword"
                                >
                                    Khôi phục
                                </button>
                                <button
                                    id="btnCancel"
                                    type="button"
                                    class="btn btn-primary"
                                    data-dismiss="modal"
                                >
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>
<script>
    import {mdbCard, mdbCardBody, mdbCol, mdbContainer, mdbRow} from "mdbvue";
    import axios from "axios";
    import VueMaterial from "vue-material";
    import "vue-material/dist/vue-material.min.css";
    import "vue-material/dist/theme/default.css";
    import Vue from "vue";
    import VueToast from "vue-toast-notification";

    Vue.use(VueMaterial);
    Vue.use(VueToast);
    export default {
        name: "LoginComponent",
        components: {
            mdbRow,
            mdbCol,
            mdbCard,
            mdbCardBody,
            mdbContainer
        },
        props: {
            url: {
                type: String,
                default: "",
            }
        },
        data() {
            return {
                email: "",
                password: "",
                errorEmail: "",
                errorPassword: "",
                errorSystem: "",
                error: "",
                emailForgot: ""
            };
        },
        methods: {
            submit() {
                axios.post(this.url, {email: this.email, password: this.password})
                    .then(() => {
                        let index = this.url.lastIndexOf('/');
                        window.location.href = this.url.slice(0, index);
                    })
                    .catch(error => {
                            this.errorEmail = "";
                            this.errorPassword = "";
                            this.errorSystem = "";
                            let errors = error.response.data.errors;
                            if (errors["email"]) {
                                this.errorEmail = errors["email"][0];
                            }
                            if (errors["password"]) {
                                this.errorPassword = errors["password"][0];
                            }
                            if (errors["system"]) {
                                this.errorSystem = errors["system"][0];
                            }
                        }
                    );
            },
            forgotPassword() {
                this.error = "";
                if (this.emailForgot === "") {
                    this.error = "Vui lòng nhập email.";
                } else {
                    if (this.url === "/lecturers/login") {
                        axios.put("/lecturers/forgot-password", {email: this.emailForgot})
                            .then((res) => {
                                if (res.data.error === false) {
                                    $("#btnCancel").click();
                                    Vue.$toast.success("<i class=\"far fa-check-circle\"></i>" + "   " + res.data.message,
                                        {position: "top-right", duration: "10000"});
                                } else {
                                    this.error = res.data.message;
                                }
                            }).catch(err => {
                                console.log(err);
                        });
                    }
                }
            },
        }
    };
</script>

<style>
    .form-elegant {
        font-size: 0.8rem;
    }

    .form-elegant .z-depth-1a {
        -webkit-box-shadow: 0 2px 5px 0 rgba(55, 161, 255, 0.26), 0 4px 12px 0 rgba(121, 155, 254, 0.25);
        box-shadow: 0 2px 5px 0 rgba(55, 161, 255, 0.26), 0 4px 12px 0 rgba(121, 155, 254, 0.25);
    }

    .form-elegant .z-depth-1-half,
    .form-elegant .btn:hover {
        -webkit-box-shadow: 0 5px 11px 0 rgba(85, 182, 255, 0.28), 0 4px 15px 0 rgba(36, 133, 255, 0.15);
        box-shadow: 0 5px 11px 0 rgba(85, 182, 255, 0.28), 0 4px 15px 0 rgba(36, 133, 255, 0.15);
    }

    @media (max-width: 768px) {
        .name-system {
            font-size: 1.5rem !important;
        }
    }

    .forgotPassword {
        font-size: 1rem;
        font-style: italic;
        color: #2196f3;
        cursor: pointer;
    }

    .forgotPassword:hover {
        text-decoration: underline;
        color: red;
    }

    .title-login{
        color: #661a00 !important;
    }
</style>
