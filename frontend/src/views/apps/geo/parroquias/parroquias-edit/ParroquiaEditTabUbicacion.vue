<template>
    <div>
        <validation-observer
            #default="{ handleSubmit }"
            v-if="parroquiaDataInfo"
            ref="refFormObserver"
        >
            <!-- Form: Personal Info Form -->
            <b-form
                class="mt-1"
                @submit.prevent="handleSubmit(onSubmit)"
                @reset.prevent="resetForm"
            >
                <b-row>
                    <b-col cols="6">
                        <!-- Form: Location Info Form -->
                        <b-row class="mt-1">
                            <!-- Field: Direccion -->
                            <b-col cols="12" md="6" lg="6">
                                <b-form-group
                                    :label="$t('Zipcode')"
                                    label-for="zipcode"
                                >
                                    <b-form-input
                                        id="zipcode"
                                        v-model="parroquiaDataInfo.zipcode"
                                        placeholder="Ej: 180150"
                                    />
                                </b-form-group>
                            </b-col>

                            <!-- Field: Tipo -->
                            <b-col cols="12" md="6" lg="6">
                                <b-form-group label="Tipo" label-for="tipo">
                                    <b-form-input
                                        id="tipo"
                                        v-model="parroquiaDataInfo.tipo"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <!-- Header: Location Info -->
                        <div class="d-flex mt-2">
                            <feather-icon icon="MapPinIcon" size="19" />
                            <h4 class="mb-0 ml-50">
                                {{ $t("Location") }}
                            </h4>
                        </div>
                        <b-row>
                            <!-- Field: Provincia -->
                            <b-col cols="12" md="6" lg="6">
                                <validation-provider
                                    #default="validationContext"
                                    :name="$t('Province')"
                                >
                                    <b-form-group
                                        :label="$t('Province')"
                                        label-for="province_id"
                                        :state="
                                            getValidationState(
                                                validationContext
                                            )
                                        "
                                    >
                                        <v-select
                                            v-model="
                                                parroquiaDataInfo.gid1
                                            "
                                            :dir="
                                                $store.state.appConfig.isRTL
                                                    ? 'rtl'
                                                    : 'ltr'
                                            "
                                            :options="provinciasOptions"
                                            @input="setProvincia"
                                            :reduce="val => val.gid1"
                                            label="nombre"
                                            :clearable="false"
                                            input-id="province_id"
                                            placeholder="Seleccione un Cantón"
                                        />
                                        <b-form-invalid-feedback
                                            :state="
                                                getValidationState(
                                                    validationContext
                                                )
                                            "
                                        >
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>

                            <!-- Field: Canton -->
                            <b-col cols="12" md="6" lg="6">
                                <validation-provider
                                    #default="validationContext"
                                    :name="$t('Canton')"
                                    rules="required"
                                >
                                    <b-form-group
                                        :label="$t('Canton')"
                                        label-for="canton_id"
                                        :state="
                                            getValidationState(
                                                validationContext
                                            )
                                        "
                                    >
                                        <v-select
                                            v-model="
                                                parroquiaDataInfo.gid2
                                            "
                                            :dir="
                                                $store.state.appConfig.isRTL
                                                    ? 'rtl'
                                                    : 'ltr'
                                            "
                                            :options="cantonesList"
                                            :reduce="val => val.gid2"
                                            label="nombre"
                                            :clearable="false"
                                            input-id="canton_id"
                                            placeholder="Seleccione un Canton"
                                        />
                                        <b-form-invalid-feedback
                                            :state="
                                                getValidationState(
                                                    validationContext
                                                )
                                            "
                                        >
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>

                            <!-- Field: Latitud -->
                            <b-col cols="12" md="6" lg="6">
                                <b-form-group
                                    label="Latitud"
                                    label-for="latitud"
                                >
                                    <b-form-input
                                        id="latitud"
                                        v-model="parroquiaDataInfo.lat"
                                    />
                                </b-form-group>
                            </b-col>

                            <!-- Field: Longitud -->
                            <b-col cols="12" md="6" lg="6">
                                <b-form-group
                                    label="Longitud"
                                    label-for="longitud"
                                >
                                    <b-form-input
                                        id="longitud"
                                        v-model="parroquiaDataInfo.lng"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <!-- Header: Location Info -->
                        <div class="d-flex mt-2">
                            <feather-icon icon="MapPinIcon" size="19" />
                            <h4 class="mb-0 ml-50">
                                {{ $t("Extent") }}
                            </h4>
                        </div>
                        <b-row>
                            <!-- Field: Minx -->
                            <b-col cols="12" md="6" lg="6">
                                <b-form-group
                                    label="Min X"
                                    label-for="minx"
                                >
                                    <b-form-input
                                        id="minx"
                                        v-model="parroquiaDataInfo.minx"
                                    />
                                </b-form-group>
                            </b-col>

                            <!-- Field: Miny -->
                            <b-col cols="12" md="6" lg="6">
                                <b-form-group
                                    label="Min Y"
                                    label-for="miny"
                                >
                                    <b-form-input
                                        id="miny"
                                        v-model="parroquiaDataInfo.miny"
                                    />
                                </b-form-group>
                            </b-col>
                            <!-- Field: Minx -->
                            <b-col cols="12" md="6" lg="6">
                                <b-form-group
                                    label="Max X"
                                    label-for="maxx"
                                >
                                    <b-form-input
                                        id="maxx"
                                        v-model="parroquiaDataInfo.maxx"
                                    />
                                </b-form-group>
                            </b-col>

                            <!-- Field: Maxy -->
                            <b-col cols="12" md="6" lg="6">
                                <b-form-group
                                    label="Max Y"
                                    label-for="maxy"
                                >
                                    <b-form-input
                                        id="maxy"
                                        v-model="parroquiaDataInfo.maxy"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <!-- Header: Location Info -->
                        <div class="d-flex mt-2">
                            <feather-icon icon="MapPinIcon" size="19" />
                            <h4 class="mb-0 ml-50">
                                {{ $t("Orientation") }}
                            </h4>
                        </div>
                        <b-row>
                            <!-- Field: Zoom -->
                            <b-col cols="12" md="6" lg="4">
                                <b-form-group
                                    label="Zoom"
                                    label-for="zoom"
                                >
                                    <b-form-input
                                        id="zoom"
                                        type="number"
                                        v-model="zoom"
                                    />
                                </b-form-group>
                            </b-col>
                            <!-- Field: Pitch -->
                            <b-col cols="12" md="6" lg="4">
                                <b-form-group
                                    label="Pitch"
                                    label-for="pitch"
                                >
                                    <b-form-input
                                        id="pitch"
                                        type="number"
                                        v-model="parroquiaDataInfo.pitch"
                                    />
                                </b-form-group>
                            </b-col>

                            <!-- Field: Bearing -->
                            <b-col cols="12" md="6" lg="4">
                                <b-form-group
                                    label="Bearing"
                                    label-for="bearing"
                                >
                                    <b-form-input
                                        id="bearing"
                                        type="number"
                                        v-model="parroquiaDataInfo.bearing"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>

                    </b-col>

                    <b-col cols="6">
                        <l-map :zoom="zoom" :center="center">
                            <l-tile-layer :url="url" />
                            <l-rectangle 
                                :bounds="bounds"
                                :l-style="rectangle.style"></l-rectangle>
                            <!-- Use default icon -->
                            <l-marker
                                :lat-lng="[
                                    parroquiaDataInfo.lat,
                                    parroquiaDataInfo.lng
                                ]"
                                :draggable="true"
                                @dragend="updateLocation"
                            />
                        </l-map>
                    </b-col>
                </b-row>

                <b-row class="mt-2">
                    <b-col>
                        <b-button
                            variant="primary"
                            class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                            type="submit"
                            :block="
                                $store.getters['app/currentBreakPoint'] === 'xs'
                            "
                        >
                            {{ $t("Save Changes") }}
                        </b-button>
                        <b-button
                            variant="outline-secondary"
                            :to="{ name: 'apps-users-list' }"
                            :block="
                                $store.getters['app/currentBreakPoint'] === 'xs'
                            "
                        >
                            {{ $t("Cancel") }}
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </div>
</template>

<script>
import {
    BRow,
    BCol,
    BForm,
    BFormGroup,
    BFormInput,
    BFormRadioGroup,
    BFormCheckboxGroup,
    BButton,
    BFormInvalidFeedback
} from "bootstrap-vue";
import flatPickr from "vue-flatpickr-component";
import Cleave from "vue-cleave-component";
import { ref } from "@vue/composition-api";
import vSelect from "vue-select";
import { useRouter } from "@core/utils/utils";
import store from "@/store";
import { useUtils as useI18nUtils } from "@core/libs/i18n";
import { LMap, LTileLayer, LMarker, LRectangle } from "vue2-leaflet";
import {  Icon } from 'leaflet'
import "leaflet/dist/leaflet.css";

// eslint-disable-next-line no-underscore-dangle
delete Icon.Default.prototype._getIconUrl
Icon.Default.mergeOptions({
  iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
  iconUrl: require('leaflet/dist/images/marker-icon.png'),
  shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
})

//Toasts
import { useToast } from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
//Form validatiom
import { extend, ValidationProvider, ValidationObserver } from "vee-validate";
import { url } from "@validations";
import formValidation from "@core/comp-functions/forms/form-validation";

export default {
    components: {
        BRow,
        BCol,
        BForm,
        BFormGroup,
        flatPickr,
        BFormInput,
        vSelect,
        BFormRadioGroup,
        BFormCheckboxGroup,
        BButton,
        BFormInvalidFeedback,
        Cleave,
        LMap,
        LTileLayer,
        LMarker,
        LRectangle,
        // Form Validation
        ValidationProvider,
        ValidationObserver
    },
    data() {
        return {
            url,
            cantonesList: [],
            url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
            zoom: this.parroquiaDataInfo.zoom,
            center: [this.parroquiaDataInfo.lat, this.parroquiaDataInfo.lng],
            bounds:[
                [this.parroquiaDataInfo.miny, this.parroquiaDataInfo.minx],
                [this.parroquiaDataInfo.maxy, this.parroquiaDataInfo.maxx],
            ],
            rectangle:{
                style: { color: 'red', weight: 3 }
            }
        };
    },
    props: {
        parroquiaData: {
            type: Object,
            required: true
        }
    },
    mounted() {
        console.log("load: " + this.parroquiaData.canton.id);
        this.loadCantones(this.parroquiaData.canton.gid2);
    },
    watch:{
        zoom () { 
            this.parroquiaDataInfo.zoom = parseInt(this.zoom)
        },
        bounds(){
            alert('bounds')
            console.log(this.bounds);
        }
    },
    methods: {
        updateLocation(location) {
            this.parroquiaDataInfo.lat = location.target._latlng.lat;
            this.parroquiaDataInfo.lng = location.target._latlng.lng;
        },
        setProvincia(provincia) {
            console.log("provincia");
            console.log(provincia);
            this.loadCantones(provincia.gid2);
        },
        loadCantones(provincia) {
            store
                .dispatch("app-geo/fetchCantonesOptions", { gid2: provincia })
                .then(response => {
                    this.cantonesList = response.data;
                });
        }
    },
    setup(props) {
        const { t } = useI18nUtils();

        const toast = useToast();
        const { route, router } = useRouter();

        const errorServer = ref(null);

        const parroquiaDataInfo = ref(
            JSON.parse(JSON.stringify(props.parroquiaData))
        );

        const provinciasOptions = ref([])

        const fetchProvincias = (ctx, callback) => {
            store
                .dispatch("app-geo/fetchProvinciasOptions", {})
                .then(response => {
                    provinciasOptions.value = response.data;
                })
                .catch(() => {
                    toast({
                        component: ToastificationContent,
                        props: {
                            title: "Error fetching provincias list",
                            icon: "AlertTriangleIcon",
                            variant: "danger"
                        }
                    });
                });
        };



        fetchProvincias()

        const onSubmit = () => {
            store
                .dispatch("app-geo/updateParroquia", parroquiaDataInfo)
                .then(response => {
                    if (response.data.status) {
                        router
                            .replace({ name: "geo-parroquias-list" })
                            .then(() => {
                                toast({
                                    component: ToastificationContent,
                                    position: "top-right",
                                    props: {
                                        title: `Actualizado`,
                                        icon: "CoffeeIcon",
                                        variant: "success",
                                        text: `Parroquia ${response.data.data.name}. Actualizada correctamente!`
                                    }
                                });
                            })
                            .catch(error => {
                                console.log("error");
                                console.log(error);
                                this.$refs.loginForm.setErrors(
                                    error.response.data.error
                                );
                            });
                    } else {
                        errorServer.value = response.data.msg;
                    }
                });
        };

        const { refFormObserver, getValidationState } = formValidation();

        return {
            parroquiaDataInfo,
            provinciasOptions,
            onSubmit,

            refFormObserver,
            getValidationState,
            errorServer
        };
    }
};
</script>
<style lang="scss">
@import "@core/scss/vue/libs/vue-flatpicker.scss";
.vue2leaflet-map {
    &.leaflet-container {
        height: 400px;
    }
}
</style>
