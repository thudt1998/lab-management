<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark white scrolling-navbar">
            <div class="navbar-brand text-black-50">
                Take Action
            </div>
        </nav>
        <div>
            <div
                class="name-system"
                style="margin-top: 14vh; font-size: 2.5rem; text-align: center; font-weight: 500"
            >
                Hệ thống phòng thí nghiệm
            </div>
            <section class="form-elegant">
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
                                        <h3 class="dark-grey-text mb-5 font-weight-bold">
                                            Đăng nhập
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
                                        <div class="text-center mb-3 mt-5">
                                            <button
                                                type="submit"
                                                class="btn btn-primary"
                                                style="width:100%; margin-left: -2px"
                                            >
                                                ログイン
                                            </button>
                                        </div>
                                    </form>
                                </mdb-card-body>
                            </mdb-card>
                        </mdb-col>
                    </mdb-row>
                </mdb-container>
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

    Vue.use(VueMaterial);
    export default {
        name: "LoginAdminComponent",
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
                url: this.url
            };
        },
        methods: {
            submit() {
                axios.post(this.url, {email: this.email, password: this.password})
                    .then(() => {
                        window.location.href = "/admin";
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
            }
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
</style>
