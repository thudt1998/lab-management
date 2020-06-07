<template>
    <loading-over-lay
        :active.sync="open"
        :can-cancel="false"
    >
        <div class="flex-row">
            <div class="text-center">
                <div
                    class="spinner-border text-primary"
                    role="status"
                />
            </div>
            <div>Loading...</div>
        </div>
    </loading-over-lay>
</template>

<script>
import LoadingOverLay from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {
    name: "Loading",
    components: {
        LoadingOverLay
    },
    props: {
        open: {
            type: Boolean,
            default: false,
        }
    },
};
</script>

<style scoped>

</style>
