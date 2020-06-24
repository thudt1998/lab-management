<template>
    <mdb-container>
        <Loading
            :open="isLoading"
        />
        <mdb-card wide>
            <div class="pl-3 pt-3">
                <button
                    class="btn btn-primary"
                    data-toggle="modal"
                    data-target="#modalAdd"
                >
                    <i class="fas fa-plus-circle"></i> Thêm
                </button>
            </div>
            <div class="margin-top style-data-table">
                <div class="margin-top font-size">
                    <strong>Danh sách đề tài</strong>
                </div>
                <div class="d-flex justify-content-end">
                    <mdb-input
                        v-model="keyword"
                        label="Tìm kiếm"
                        class="mb-0"
                        @change="searchCompanies"
                    />
                </div>
                <table
                    class="table table-striped table-responsive-lg"
                >
                    <thead>
                    <tr>
                        <th
                            class="th-sm"
                            @click="sortCompanies('company_id_3rd')"
                        >
                            <mdb-icon
                                v-if="sortBy === 'company_id_3rd' && sort === 'ASC'"
                                icon="sort-up"
                            />
                            <mdb-icon
                                v-if="sortBy === 'company_id_3rd' && sort === 'DESC'"
                                icon="sort-down"
                            />
                            <span class="font-weight-500">ID</span>
                        </th>
                        <th class="th-sm" style="text-align: center">
                            <span class="font-weight-500">Tên đề tài</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="topic in topics"
                        :key="topic.id"
                        style="cursor: pointer"
                        title="Xem chi tiết"
                        @click="onclickRow(topic.id)"
                    >
                        <td style="width: 20%">
                            {{ topic.id }}
                        </td>
                        <td style="width: 80%;text-align: center">
                            {{ topic.name }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <paging
                    :pagination="pagination"
                    :offset="2"
                    :per-page="10"
                    @paginate="changePage"
                />
                <div
                    v-show="topics.length === 0"
                    class="white text-center text-black-50"
                >
                    {{messageNoData}}
                </div>
            </div>
        </mdb-card>
        <div
            class="modal fade"
            id="modalAdd"
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
                        >
                            Thêm đề tài
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
                            <label for="name">Tên đề tài</label>
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

    Vue.use(VueToast);
    export default {
        name: "TopicComponent",
        components: {
            mdbCard,
            mdbContainer,
            mdbInput,
            mdbIcon,
            Loading
        },
        data() {
            return {
                isLoading: false,
                name: "",
                errorName: "",
                messageNoData: strings.messageNoData
            };
        },
        created() {
            if (this.topicCreateSuccess) {
                Vue.$toast.success("<i class=\"far fa-check-circle\"></i>" + "   " + this.topicCreateSuccess,
                    {position: "top-right", duration: "10000"});
            }
            if (this.topicCreateFail) {
                Vue.$toast.error("<i class=\"far fa-times-circle\"></i>" + "   " + this.topicCreateFail,
                    {position: "top-right", duration: "10000"});
            }
        },
        props: {
            topics: {
                type: Array,
                default: []
            },
            topicCreateSuccess: {
                type: String,
                default: ""
            },
            topicCreateFail: {
                type: String,
                default: ""
            }
        },
        methods: {
            validateCreate() {
                Vue.$toast.clear();
                if (!this.name) {
                    if (!this.name) {
                        this.errorName = strings.nameIsRequired;
                    } else {
                        this.errorName = "";
                    }
                } else {
                    this.addTopic();
                }
            },
            addTopic() {
                this.isLoading = true;
                axios.post('/lecturers/topics', {name: this.name})
                    .then(() => {
                        $('#btnCloseModal').click();
                        this.isLoading = false;
                        location.reload();
                    }).catch((error) => {
                    console.log(error);
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
</style>
