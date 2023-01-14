<template>
    <b-card no-body>
        <b-card-header class="pb-50">
            <h5>
                {{ $t("Filters") }}
            </h5>
        </b-card-header>
        <b-card-body>
            <b-row>
                <!-- v-model="userFilter" -->
                <b-col cols="12" md="4" class="mb-md-0 mb-2">
                    <label>{{ ("Parroquia") }}</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="parroquiaFilter"
                        :options="parroquiasOptions"
                        class="w-100"
                        label="nombre"
                        :reduce="val => val.id.toString()"
                        @input="val => $emit('update:parroquiaFilter', val)"
                        placeholder="Seleccione la parroquia"
                        :readonly="true"
                    />
                </b-col>
                <b-col cols="12" md="4" class="mb-md-0 mb-2">
                   <label>{{ ("Recinto") }}</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="recintoFilter"
                        :options="recintosOptions"
                        class="w-100"
                        label="nombre"
                        :reduce="val => val.id.toString()"
                        @input="val => $emit('update:recintoFilter', val)"
                        placeholder="Seleccione el recinto"
                    />
                </b-col>
                <b-col cols="12" md="4" class="mb-md-0 mb-2">
                   <label>{{ ("Junta") }}</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="juntaFilter"
                        :options="juntasOptions"
                        class="w-100"
                        label="codigo"
                        :reduce="val => val.id.toString()"
                        @input="val => $emit('update:juntaFilter', val)"
                        placeholder="Seleccione la junta"
                    />
                </b-col>
            </b-row>
        </b-card-body>
    </b-card>
</template>
<script>
import { BCard, BCardHeader, BCardBody, BRow, BCol } from "bootstrap-vue";
import vSelect from "vue-select";

export default {
    components: {
        BRow,
        BCol,
        BCard,
        BCardHeader,
        BCardBody,
        vSelect,
    },
    props: {
       parroquiaFilter: {
            type: [String, null],
            default: null
        },
        recintoFilter: {
            type: [String, null],
            default: null
        },
        juntaFilter: {
            type: [String, null],
            default: null
        },
        parroquiasOptions: {
            type: Array,
            required: true,
        },
        recintosOptions: {
            type: Array,
            required: true,
        },
        juntasOptions: {
            type: Array,
            required: true,
        },
       
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