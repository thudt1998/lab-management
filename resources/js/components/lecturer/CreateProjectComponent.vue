<template>
    <mdb-container>
        <mdb-card wide>
            <Loading
                :open="isLoading"
            />
            <div class="container div-add">
                <div>
                    <h2
                        class="modal-title text-center"
                        style="color: #661a00; font-weight: bold"
                    >
                        Đăng ký project
                    </h2>
                </div>
                <div class="form-add">
                    <div class="form-group">
                        <label for="name">Đề tài</label>
                        <multiselect
                            v-model="topicsSelected"
                            :options="topics"
                            placeholder="Chọn đề tài"
                            track-by="name"
                            label="name"
                            :searchable="false"
                            :close-on-select="false"
                            :multiple="true"
                        >
                        </multiselect>
                        <span
                            v-if="errorTopic"
                            class="error-validate"
                        >
                                {{errorTopic}}
                            </span>
                    </div>
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
                            v-if="errorLaboratory"
                            class="error-validate"
                        >
                                {{errorLaboratory}}
                            </span>
                    </div>
                    <div class="form-group" v-if="laboratory">
                        <label for="email">Ngăn</label>
                        <select
                            class="browser-default custom-select"
                            v-model="compartment"
                            :class="{'error-input':errorCompartment}"
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
                            v-if="errorCompartment"
                            class="error-validate"
                        >
                                {{errorCompartment}}
                            </span>
                    </div>
                    <div v-if="compartment">
                        <span class="span-structure">Số bàn: </span><span
                        class="value-structure">{{compartment.tables}}</span>,
                        <span class="span-structure">Số ghế: </span><span
                        class="value-structure">{{compartment.chairs}}</span>,
                        <span class="span-structure">Số máy tính: </span>
                        <span class="value-structure">{{compartment.computers}}</span>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addInfrastructure">Yêu cầu
                            thêm
                        </button>
                        <span class="span-structure" v-if="tables>0 || chairs>0 || computers>0">
                            (Yêu cầu thêm: {{tables}} <span class="value-structure">bàn</span>,
                            <span class="value-structure">{{chairs}}</span> ghế,
                            <span class="value-structure">{{computers}}</span> máy tính)
                        </span>
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
                        <div class="modal-dialog modal-lg" role="document" style="width: 600px">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4
                                        class="modal-title"
                                        style="color: #661a00"
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
                                <div class="modal-body ml-4 mr-4">
                                    <div class="form-group">
                                        <label for="name">Số bàn</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            v-model="tables"
                                            min="0"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Số ghế</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            v-model="chairs"
                                            min="0"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="classStudent">Số máy tính</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            v-model="computers"
                                            min="0"
                                        />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-primary"
                                        @click="addFacilities"
                                    >
                                        Thêm
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="start">Ngày bắt đầu</label>
                        <input
                            type="date"
                            class="form-control"
                            v-model="dateStart"
                            :class="{'error-input':errorDateStart}"
                        />
                        <span
                            v-if="errorDateStart"
                            class="error-validate"
                        >
                                {{errorDateStart}}
                            </span>
                    </div>
                    <div class="form-group">
                        <label for="finish">Ngày kết thúc</label>
                        <input
                            type="date"
                            class="form-control"
                            v-model="dateFinish"
                            :class="{'error-input':errorDateFinish}"
                        />
                        <span
                            v-if="errorDateFinish"
                            class="error-validate"
                        >
                                {{errorDateFinish}}
                            </span>
                    </div>
                    <div class="form-group">
                        <label for="finish">Sinh viên</label>
                        <vue-tags-input
                            v-model="tag"
                            :tags="tags"
                            :autocomplete-items="autocompleteItems"
                            :add-only-from-autocomplete="true"
                            @tags-changed="update"
                            placeholder="Nhập tên sinh viên"
                        />
                        <span
                            v-if="errorStudent"
                            class="error-validate"
                        >
                                {{errorStudent}}
                            </span>
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
        </mdb-card>
    </mdb-container>
</template>

<script>
    import Vue from "vue";
    import axios from "axios";
    import Loading from "../common/Loading";
    import "vue-toast-notification/dist/theme-default.css";
    import {strings} from "../../strings";
    import {mdbCard, mdbContainer, mdbIcon, mdbInput} from "mdbvue";
    import VueTagsInput from '@johmun/vue-tags-input';
    import {Multiselect} from 'vue-multiselect';

    Vue.component('multiselect', Multiselect);
    export default {
        name: "StudentComponent",
        components: {
            mdbCard,
            mdbContainer,
            mdbInput,
            mdbIcon,
            Loading,
            VueTagsInput,
            Multiselect,
        },
        data() {
            return {
                isLoading: false,
                laboratory: "",
                name: "",
                dateStart: "",
                dateFinish: "",
                compartment: "",
                compartments: [],
                tag: '',
                tags: [],
                autocompleteItems: [],
                debounce: null,
                students: [],
                topicsSelected: [],
                errorTopic: "",
                errorName: "",
                errorLaboratory: "",
                errorCompartment: "",
                errorDateStart: "",
                errorDateFinish: "",
                tables: 0,
                chairs: 0,
                computers: 0,
                errorStudent: "",
            };
        },
        watch: {
            'tag': 'initItems',
        },
        props: {
            laboratories: {
                type: Array,
                default: ""
            },
            topics: {
                type: Array,
                default: ""
            }
        },
        methods: {
            changeLaboratory() {
                this.compartments = this.laboratory.compartments;
                this.clearAdd();
            },
            clearAdd() {
                this.tables = 0;
                this.chairs = 0;
                this.computers = 0;
            },
            addFacilities() {
                $("#btnCloseModal").click();
            },
            validateCreate() {
                this.clearErrors();
                if (!this.name || !this.laboratory || !this.compartment || this.topicsSelected.length <= 0 || !this.dateStart || !this.dateFinish || this.tags.length <= 0) {
                    if (!this.name) {
                        this.errorName = strings.nameProjectRequired;
                    } else {
                        this.errorName = "";
                    }
                    if (!this.laboratory) {
                        this.errorLaboratory = strings.laboratoryRequired;
                    } else {
                        this.errorLaboratory = "";
                    }
                    if (!this.compartment) {
                        this.errorCompartment = strings.compartmentRequired;
                    } else {
                        this.errorCompartment = "";
                    }
                    if (this.topicsSelected.length <= 0) {
                        this.errorTopic = strings.topicRequired;
                    } else {
                        this.errorTopic = "";
                    }
                    if (!this.dateStart) {
                        this.errorDateStart = strings.dateStartRequired;
                    } else {
                        this.errorDateStart = "";
                    }
                    if (!this.dateFinish) {
                        this.errorDateFinish = strings.dateFinishRequired;
                    } else {
                        this.errorDateFinish = "";
                    }
                    if (this.tags.length <= 0) {
                        this.errorStudent = strings.studentRequired;
                    } else {
                        this.errorStudent = "";
                    }
                } else {
                    this.addProject();
                }
            },
            clearErrors() {
                this.errorName = "";
                this.errorLaboratory = "";
                this.errorCompartment = "";
                this.errorTopic = "";
                this.errorDateStart = "";
                this.errorDateFinish = "";
                this.errorStudent = "";
            },
            addProject() {
                this.isLoading = true;
                axios.post('/lecturers/projects',
                    {
                        name: this.name,
                        compartment_id: this.compartment.id,
                        topics: this.topics,
                        date_start: this.dateStart,
                        date_finish: this.dateFinish,
                        students: this.tags,
                        tables: this.tables,
                        chairs: this.chairs,
                        computers: this.computers,
                    }).then(() => {
                    $('#btnCloseModal').click();
                    this.isLoading = false;
                    history.back(1);
                }).catch((error) => {
                    this.clearErrors();
                    let errors = error.response.data.errors;
                    if (errors["name"]) {
                        this.errorName = errors["name"][0];
                    }
                    if (errors["compartment_id"]) {
                        this.errorCompartment = errors["compartment_id"][0];
                    }
                    if (errors["topics"]) {
                        this.errorTopic = errors["topics"][0];
                    }
                    if (errors["date_start"]) {
                        this.errorDateStart = errors["date_start"][0];
                    }
                    if (errors["date_finish"]) {
                        this.errorDateFinish = errors["date_finish"][0];
                    }
                    if (errors["students"]) {
                        this.errorStudent = errors["students"][0];
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
                            return {text: student.name, id: student.id};
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
        padding: 20px;
    }

    .form-add {
        padding: 40px 80px 20px 80px;
    }

    .span-structure {
        color: #661a00;
        font-style: italic;
    }

    .value-structure {
        font-weight: bold;
    }
</style>
<style scoped>
    .font-m {
        color: #448aff;
    }

    .vue-tags-input{
        max-width: 100%;
    }
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
