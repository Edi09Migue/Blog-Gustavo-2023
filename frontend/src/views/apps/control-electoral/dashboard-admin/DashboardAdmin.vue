<template>
  <div>
    <b-row class="match-height">
        <b-col
            xl="12"
            md="12"
        >
        <counters :counters-data="statisticsItems"/>
        </b-col>
    </b-row>

  </div>
</template>

<script>
import { BCard, BCardText, BLink, BRow, BCol } from 'bootstrap-vue'
import store from "@/store";
import dashboardAdminStoreModule from "./dashboardAdminStoreModule";
import { onUnmounted } from "@vue/composition-api";
import useDashboardAdmin from './useDashboardAdmin'
import Counters from './Counters.vue'

export default {
    components: {
        BCard,
        BCardText,
        BLink,
        BRow,
        BCol,
        Counters,
    },

    setup() {

        const DASHBOARD_APP_STORE_MODULE_NAME = "control-dashboard";

        // Register module
        if (!store.hasModule(DASHBOARD_APP_STORE_MODULE_NAME))
            store.registerModule(
                DASHBOARD_APP_STORE_MODULE_NAME,
                dashboardAdminStoreModule
            );

        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(DASHBOARD_APP_STORE_MODULE_NAME))
                store.unregisterModule(DASHBOARD_APP_STORE_MODULE_NAME);
        });


        const{
            statisticsItems,
        } = useDashboardAdmin()

        return {
            statisticsItems,
        };





    }

}

</script>


