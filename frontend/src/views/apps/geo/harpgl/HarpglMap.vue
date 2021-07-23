<template>
    <div>
        <b-card title="HarpGL Map Viewer">
            <b-card-body>
                <viewer
                    token="AIPZ5Z9ERwOH_2Q0wXABIAA"
                    lat="-1.2478097622774458"
                    lng="-78.6246227200658"
                />
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import Viewer from "./Viewer.vue";
import { BCard, BCardBody } from "bootstrap-vue";
export default {
    name: "app",
    components: {
        BCard,
        BCardBody,
        Viewer
    }
};
</script>

<style></style>
