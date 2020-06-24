<template>
    <mdb-container>
        <Loading
            :open="isLoading"
        />
        <div class="container div-add">
            <div>
                <h4
                    class="modal-title text-center"
                >
                    Thêm sinh viên
                </h4>
            </div>
            <div class="form-add">
                <div class="form-group">
                    <label for="name">Tên project</label>
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
                    <label for="email">Phòng</label>
                    <select
                        class="browser-default custom-select"
                        v-model="laboratory"
                        :class="{'error-input':errorLaboratory}"
                        @change="changeLaboratory"
                    >
                        <option
                            v-for="laboratory in laboratories"
                            :value="laboratory"
                            :key="laboratory.id"
                        >
                            {{laboratory.name}}
                        </option>
                    </select>
                    <span
                        v-if="errorEmail"
                        class="error-validate"
                    >
                                {{errorEmail}}
                            </span>
                </div>
                <div class="form-group" v-if="laboratory">
                    <label for="email">Ngăn</label>
                    <select
                        class="browser-default custom-select"
                        v-model="compartment"
                        :class="{'error-input':errorLaboratory}"
                    >
                        <option
                            v-for="compartment in compartments"
                            :value="compartment"
                            :key="compartment.id"
                        >
                            {{compartment.name}}
                        </option>
                    </select>
                    <span
                        v-if="errorEmail"
                        class="error-validate"
                    >
                                {{errorEmail}}
                            </span>
                </div>
                <div  v-if="compartment">
                    Số bàn: {{compartment.tables}}
                    Số ghế: {{compartment.chairs}}
                    Số máy tính: {{compartment.computers}}
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addInfrastructure">Yêu cầu thêm</button>
                </div>
                <div
                    class="modal fade"
                    id="addInfrastructure"
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
                                >
                                    Yêu cầu cơ sở vật chất
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
                            <div class="modal-body">
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
                                    <label for="classStudent">Lớp</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="classStudent"
                                    />
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
                <div class="form-group">
                    <label for="start">Ngày bắt đầu</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="dateStart"
                    />
                </div>
                <div class="form-group">
                    <label for="finish">Ngày kết thúc</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="dateFinish"
                    />
                </div>
                <div class="form-group">
                    <label for="finish">Sinh viên</label>
                    <vue-tags-input
                        v-model="tag"
                        :tags="tags"
                        :autocomplete-items="autocompleteItems"
                        :add-only-from-autocomplete="true"
                        @tags-changed="update"
                    />
                </div>
            </div>
            <div class="d-flex align-content-center justify-content-center">
                <button
                    type="button"
                    class="btn btn-primary"
                    @click="validateCreate"
                >
                    Tạo
                </button>
            </div>
        </div>
    </mdb-container>
</template>

<script>
    import Vue from "vue";
    import axios from "axios";
    import Loading from "../common/Loading";
    import VueToast from "vue-toast-notification";
    import "vue-toast-notification/dist/theme-default.css";
    import {strings} from "../../strings";
    import {mdbCard, mdbContainer, mdbIcon, mdbInput} from "mdbvue";
    import VueTagsInput from '@johmun/vue-tags-input';

    Vue.use(VueToast);
    export default {
        name: "StudentComponent",
        components: {
            mdbCard,
            mdbContainer,
            mdbInput,
            mdbIcon,
            Loading,
            VueTagsInput,
        },
        data() {
            return {
                isLoading: false,
                laboratory: "",
                dateStart: "",
                dateFinish: "",
                compartment: "",
                compartments: [],
                tag: '',
                tags: [],
                autocompleteItems: [],
                debounce: null,
                students: []
            };
        },
        watch: {
            'tag': 'initItems',
        },
        props: {
            laboratories: {
                type: Array,
                default: ""
            }
        },
        methods: {
            changeLaboratory() {
                this.compartments = this.laboratory.compartments;
            },
            validateCreate() {
                Vue.$toast.clear();
                if (!this.name || !this.email) {
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
                } else {
                    this.addLecturer();
                }
            },
            addLecturer() {
                this.isLoading = true;
                axios.post('/lecturers/students', {name: this.name, email: this.email, class: this.classStudent})
                    .then((res) => {
                        $('#btnCloseModal').click();
                        this.isLoading = false;
                        location.reload();
                    }).catch((error) => {
                    this.errorName = "";
                    this.errorEmail = "";
                    let errors = error.response.data.errors;
                    if (errors["name"]) {
                        this.errorName = errors["name"][0];
                    }
                    if (errors["email"]) {
                        this.errorEmail = errors["email"][0];
                    }
                });
            },
            update(newTags) {
                this.autocompleteItems = [];
                this.tags = newTags;
            },
            initItems() {
                if (this.tag.length < 2) return;
                clearTimeout(this.debounce);
                this.debounce = setTimeout(() => {
                    axios.get(`/lecturers/search-student?name=${this.tag}`).then(response => {
                        this.autocompleteItems = response.data.data.map(student => {
                            return {text: student.name};
                        });
                    }).catch((e) => console.log(e));
                }, 600);
            },
        }
    }
</script>

<style scoped>
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

    .div-add {
        background-color: #f2f2f2;
        padding: 20px;
    }

    .form-add {
        padding: 40px 80px 20px 80px;
    }
</style>
