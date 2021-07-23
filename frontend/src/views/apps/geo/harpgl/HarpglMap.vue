<template>
    <div>
        <h1>HarglMap</h1>
        <canvas id="map"></canvas>
    </div>
</template>
<script>
export default {
    methods: {
        initMap: function() {
            const canvas = document.getElementById("map");
            const mapView = new harp.MapView({
                canvas,
                theme:
                    "https://unpkg.com/@here/harp-map-theme@latest/resources/berlin_tilezen_night_reduced.json"
            });

            // center the camera to New York
            mapView.lookAt({
                target: new harp.GeoCoordinates(40.70398928, -74.01319808),
                zoomLevel: 17,
                tilt: 40
            });

            const mapControls = new harp.MapControls(map);
            const ui = new harp.MapControlsUI(mapControls);
            canvas.parentElement.appendChild(ui.domElement);

            mapView.resize(window.innerWidth, window.innerHeight);
            window.onresize = () =>
                mapView.resize(window.innerWidth, window.innerHeight);

            const vectorTileDataSource = new harp.VectorTileDataSource({
                authenticationCode: "YOUR-TOKEN HERE"
            });
            mapView.addDataSource(vectorTileDataSource);
        }
    },
    mounted() {
        let jsThreeScript = document.createElement("script");
        jsThreeScript.setAttribute(
            "src",
            "https://unpkg.com/three/build/three.min.js"
        );
        document.head.appendChild(jsThreeScript);
        let jsHarpScript = document.createElement("script");
        jsHarpScript.setAttribute(
            "src",
            "https://unpkg.com/@here/harp.gl/dist/harp.js"
        );
        document.head.appendChild(jsHarpScript);
        this.initMap();
    },
    setup() {}
};
</script>
<style>
#map {
    height: 100vh;
    width: 100vw;
}
</style>
