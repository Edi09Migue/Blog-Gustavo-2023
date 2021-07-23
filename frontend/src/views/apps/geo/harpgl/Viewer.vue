<template>
    <div>
        <canvas ref="map" style="width: 100%; height: 100vh"></canvas>
    </div>
</template>

<script>
//import GeoJSON from "geojson";
export default {
    name: "HarpMap",
    props: {
        token: String,
        lat: String,
        lng: String
    },
    mounted() {
        this.map = new harp.MapView({
            canvas: this.$refs.map,
            theme:
                "https://unpkg.com/@here/harp-map-theme@latest/resources/berlin_tilezen_night_reduced.json"
        });
        const controls = new harp.MapControls(this.map);
        const omvDataSource = new harp.OmvDataSource({
            baseUrl: "https://xyz.api.here.com/tiles/herebase.02",
            apiFormat: harp.APIFormat.XYZOMV,
            styleSetName: "tilezen",
            authenticationCode: this.token
        });
        this.map.addDataSource(omvDataSource);
        this.map.setCameraGeolocationAndZoom(
            new harp.GeoCoordinates(Number(this.lat), Number(this.lng)),
            12
        );
    },
    methods: {
        createPoints(positions) {},
        dropPoints(name, positions) {}
    }
};
</script>

<style scoped></style>
