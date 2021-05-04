<template>
    <b-card no-body>
        <b-card-header class="pb-50">
            <h5>
                {{ $t("Filters") }}
            </h5>

            <users-import-modal @refetch-data="refetchData" />
        </b-card-header>
        <b-card-body>
            <b-row>
                <b-col cols="12" md="4" class="mb-md-0 mb-2">
                    <label>{{ $t("Role") }}</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="roleFilter"
                        :options="roleOptions"
                        class="w-100"
                        :reduce="val => val.value"
                        @input="val => $emit('update:roleFilter', val)"
                    />
                </b-col>
                <b-col cols="12" md="4" class="mb-md-0 mb-2">
                    <label>Plan</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="planFilter"
                        :options="planOptions"
                        class="w-100"
                        :reduce="val => val.value"
                        @input="val => $emit('update:planFilter', val)"
                    />
                </b-col>
                <b-col cols="12" md="4" class="mb-md-0 mb-2">
                    <label>{{ $t("Status") }}</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="statusFilter"
                        :options="statusOptions"
                        class="w-100"
                        :reduce="val => val.value"
                        @input="val => $emit('update:statusFilter', val)"
                    />
                </b-col>
            </b-row>
        </b-card-body>
    </b-card>
</template>

<script>
import { BCard, BCardHeader, BCardBody, BRow, BCol } from "bootstrap-vue";
import vSelect from "vue-select";

import UsersImportModal from "./UsersImporModal";
export default {
    components: {
        BRow,
        BCol,
        BCard,
        BCardHeader,
        BCardBody,
        vSelect,
        UsersImportModal
    },
    props: {
        roleFilter: {
            type: [String, null],
            default: null
        },
        planFilter: {
            type: [String, null],
            default: null
        },
        statusFilter: {
            type: [String, null],
            default: null
        },
        roleOptions: {
            type: Array,
            required: true
        },
        planOptions: {
            type: Array,
            required: true
        },
        statusOptions: {
            type: Array,
            required: true
        }
    },
    methods: {
        refetchData() {
            this.$emit("refetch-data");
        }
    }
};
</script>

<style lang="scss">
@import "@core/scss/vue/libs/vue-select.scss";
</style>
