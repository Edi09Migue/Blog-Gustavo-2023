<template>
  <b-card :title="$t('Map')">
    <p>Este mapa muestra el Extent de la provincia y la ubicación del centro poblado más representativo de la zona</p>
    <b-row>
      <!-- Right Col: Table -->
      <b-col
        cols="12"
        xl="12"
      >
        <l-map :zoom="zoom" :center="center">
           
            <l-control-layers
              position="bottomright"
              :collapsed="false"
              :sort-layers="true"
            />
            <!-- <l-tile-layer :url="url" /> -->
              <l-tile-layer
                v-for="tileProvider in tileProviders"
                :key="tileProvider.name"
                :name="tileProvider.name"
                :visible="tileProvider.visible"
                :url="tileProvider.url"
                :attribution="tileProvider.attribution"
                :token="token"
                layer-type="base"
              />

              <l-wms-tile-layer
                v-for="layerWMS in rrnnLayers"
                :key="layerWMS.name"
                :name="layerWMS.name"
                :layers="layerWMS.layers"
                :opacity="layerWMS.opacity"
                :visible="layerWMS.visible"
                :base-url="layerWMS.url"
                :format="layerWMS.format"
                :bbox="layerWMS.bbox"
                :attribution="layerWMS.attribution"
                :crs="layerWMS.crs"
                :token="token"
                layer-type="overlay"
              />
             

                <l-control-scale :imperial="imperial" />
                <l-rectangle 
                    :bounds="bounds"
                    :l-style="rectangle.style"></l-rectangle>
                <!-- Use default icon -->
                <l-marker
                    :lat-lng="[
                        provinciaData.lat,
                        provinciaData.lng
                    ]"
            />
        </l-map>
      </b-col>
    </b-row>
  </b-card>
</template>

<script>
import {
  BCard, BButton, BAvatar, BRow, BCol, BCardText, BCardHeader
} from 'bootstrap-vue'
import { avatarText } from '@core/utils/filter'

import { useUtils as useI18nUtils } from "@core/libs/i18n";
import { LMap, LTileLayer, LMarker, LRectangle, LControlScale, LControlLayers, LLayerGroup, LWMSTileLayer } from "vue2-leaflet";
import {  Icon } from 'leaflet'
import "leaflet/dist/leaflet.css";
// eslint-disable-next-line no-underscore-dangle
delete Icon.Default.prototype._getIconUrl
Icon.Default.mergeOptions({
  iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
  iconUrl: require('leaflet/dist/images/marker-icon.png'),
  shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
})

const tileProviders = [
  {
    name: 'OpenStreetMap',
    visible: true,
    attribution:
      '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
    url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
  },
  {
    name: 'OpenTopoMap',
    visible: false,
    url: 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',
    attribution:
      'Map data: &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)',
  },
]

const rrnnLayers = [
    {
    name: 'Parroquias',
    visible: true,
    format: 'image/png; mode=8bit',
    transparent: true,
    opacity: 0.6,
    layers: 'parroquias',
    version: '1.1.1',
    bbox :'-78.857685631137,-1.4218850961551,-78.202410690726,-1.1609180413979',
    crs: L.CRS.EPSG4326,
    attribution:'&copy; <a target="_blank" href="http://rrnn.tungurahua.gob.ec">GeoPortal HGPT</a>',
    url: 'http://mapas.tungurahua.gob.ec/base?_signature=35%3AtQ4w1U9PYXX2oUR-XmrygmZzxcU&',
  },
    {
    name: 'Cantones',
    visible: false,
    format: 'image/png; mode=8bit',
    transparent: true,
    opacity: 0.6,
    layers: 'tungurahuacantones',
    version: '1.1.1',
    bbox :'-78.857685631137,-1.4218850961551,-78.202410690726,-1.1609180413979',
    crs: L.CRS.EPSG4326,
    attribution:'&copy; <a target="_blank" href="http://rrnn.tungurahua.gob.ec">GeoPortal HGPT</a>',
    url: 'http://mapas.tungurahua.gob.ec/base?_signature=35%3AtQ4w1U9PYXX2oUR-XmrygmZzxcU&',
  }

]

export default {
  components: {
    BCard, BButton, BRow, BCol, BAvatar, BCardText, BCardHeader,
    LMap,
    LTileLayer,
   'l-wms-tile-layer': LWMSTileLayer,
    LMarker,
    LRectangle,
    LControlScale,
    LControlLayers, LLayerGroup
  },
    data() {
        return {
            cantonesList: [],
            url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
            zoom: this.provinciaData.zoom,
            token:'mapbox token',
            imperial: false,
            center: [this.provinciaData.lat, this.provinciaData.lng],
            bounds:[
                [this.provinciaData.miny, this.provinciaData.minx],
                [this.provinciaData.maxy, this.provinciaData.maxx],
            ],
            rectangle:{
                style: { color: 'red', weight: 3 }
            },
            tileProviders,
            rrnnLayers
        };
    },
  props: {
    provinciaData: {
      type: Object,
      required: true,
    },
  },
  setup() {
    return {      
      avatarText,
    }
  },
}
</script>
<style lang="scss">
@import "@core/scss/vue/libs/vue-flatpicker.scss";
.vue2leaflet-map {
    &.leaflet-container {
        height: 400px;
    }
}
</style>
