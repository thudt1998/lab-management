<template>
    <div v-show="pagination.total > perPage">
        <div
            class="d-flex justify-content-between register_pager"
        >
            <p style="font-size: 0.9rem; margin-top: 0.5rem">
                Hiển thị <strong>{{ pagination.from }}</strong> đến <strong>{{ pagination.to }}</strong> trong <strong>{{ pagination.total }}</strong> bản ghi
            </p>
            <ul class="pagination pg-blue pagination-sm">
                <li
                    :class="notFirstPage() ? 'page-item' : 'page-item disabled'"
                >
                    <a
                        href="javascript:void(0)"
                        class="page-link"
                        @click.prevent="changePage(1)"
                    >
                        <mdb-icon icon="angle-double-left" />
                    </a>
                </li>
                <li
                    :class="notFirstPage() ? 'page-item' : 'page-item disabled'"
                >
                    <a
                        href="javascript:void(0)"
                        class="page-link"
                        @click.prevent="changePage(pagination.current_page - 1)"
                    >
                        <mdb-icon icon="angle-left" />
                    </a>
                </li>
                <li
                    v-for="(page, key) in pagesNumber"
                    :key="key"
                    :class="page === pagination.current_page ? 'page-item active' : 'page-item'"
                >
                    <span
                        v-if="page === pagination.current_page"
                        class="page-link"
                    >
                        {{ page }}
                    </span>
                    <a
                        v-else
                        href="javascript:void(0)"
                        class="page-link text-dark text-decoration-none"
                        @click.prevent="changePage(page)"
                    >
                        {{ page }}
                    </a>
                </li>
                <li
                    :class="hasMorePage() ? 'page-item' : 'page-item disabled'"
                >
                    <a
                        href="javascript:void(0)"
                        class="page-link"
                        @click.prevent="changePage(pagination.current_page + 1)"
                    >
                        <mdb-icon icon="angle-right" />
                    </a>
                </li>
                <li
                    :class="hasMorePage() ? 'page-item' : 'page-item disabled'"
                >
                    <a
                        href="javascript:void(0)"
                        class="page-link"
                        @click.prevent="changePage(pagination.last_page)"
                    >
                        <mdb-icon icon="angle-double-right" />
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import { mdbIcon } from "mdbvue";

export default {
    name: "Paging",
    components: {
        mdbIcon,
    },
    props: {
        pagination: {
            type: Object,
            required: true
        },
        perPage: {
            type: Number,
            required: true,
        },
        offset: {
            type: Number,
            default: 4
        }
    },
    computed: {
        pagesNumber() {
            if (!this.pagination.to) {
                return [];
            }
            let from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            let to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            let pagesArray = [];
            for (let page = from; page <= to; page++) {
                pagesArray.push(page);
            }
            return pagesArray;
        }
    },
    methods: {
        hasMorePage() {
            return this.pagination.current_page < this.pagination.last_page;
        },
        notFirstPage() {
            return this.pagination.current_page > 1;
        },
        changePage(page) {
            this.pagination.current_page = page;
            this.$emit("paginate", page);
        }
    },
};
</script>

<style scoped>
    .pagination a:hover {
        color: #343A40 !important;
    }
</style>
