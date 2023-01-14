<template>
    <section class="invoice-preview-wrapper">
        <!-- Alert: No item found -->
        <b-alert variant="danger" :show="actaData === undefined">
            <h4 class="alert-heading">Error obteniendo datos de la receta</h4>
            <div class="alert-body">
                No se encontro una receta con ese Id. Verifique
                <b-link
                    class="alert-link"
                    :to="{ name: 'control-actas-list'}"
                >
                    el Listado de Recetas
                </b-link>
            </div>
        </b-alert>

        <template v-if="actaData">

            
            <div class="d-flex justify-content-end">
                <div class="demo-inline-spacing">
                        <b-button
                            v-if="$can('descargar', 'oficios')"
                            v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                            variant="outline-secondary"
                            block
                            class="mt-0 mb-1"
                            :to="{
                                name: 'control-actas-edit',
                                params: { id: actaData.id,}
                            }"
                           
                        >
                            <feather-icon icon="EditIcon" />
                            <span class="text-secondary">
                                Editar
                            </span>
                        </b-button>

                        <!-- <oficio-modal-list-add-new
                        
                            v-if="ultimoJefe"
                            v-model="showModalOficio"
                            :modelo-oficio="oficioData"
                        
                            :ultimoJefe="ultimoJefe"
                            @refetch-data="refetchData"
                            :is-button-disabled="isButtonDisabled"
                            @add-oficio="addOficio"
                            @update-oficio="updateOficio"
                            :module="OFICIOS_APP_STORE_MODULE_NAME"
                            @cerrar-modal="cerrarModal"
                        /> -->
                        
                    </div>
            </div>


        <b-img
            :src="actaData.imagenURL"
            width="150"
            size="150"
            fluid
            rounded
        />
        <h2 class="mt-1">Detalle de votos:</h2>



            <!-- <b-row>
                <b-col
                    cols="12"
                    md="12"
                    lg="12"
                    xl="12"
                >
                    <receta-view-info-card :receta-data="actaData" />
                </b-col>
            </b-row>

            <b-row>
                <b-col
                    xl="12"
                    md="12"
                >
                <receta-statistics :counters-data="statisticsItems"/>
                </b-col>
            </b-row>


            <b-row>
                <b-col
                    xl="12"
                    md="12"
                >
                    <receta-detalles :receta-data="actaData"/>
                </b-col>
            </b-row> -->
            


            

        

        </template>





    </section>
</template>

<script>
import {
    BRow,
    BCol,
    BCard,
    BCardBody,
    BTableLite,
    BCardText,
    BButton,
    BAlert,
    BLink,
    BListGroup,
    BListGroupItem,
    VBToggle,
    VBModal,
    BBadge,
    BCardFooter,
    BCardSubTitle,
    BFormGroup,
    BImg,
    BCardHeader,
    BFormInput,
    BFormCheckbox,

    
} from "bootstrap-vue";
import { ref, onUnmounted } from "@vue/composition-api";
import store from "@/store";
import router from "@/router";
import { formatDate } from "@core/utils/filter";
import Ripple from "vue-ripple-directive";
import { title } from "@core/utils/filter";
import actasStoreModule from "../actasStoreModule";
import useActaView from "./useActaView";
import vSelect from "vue-select";
// import RecetaViewInfoCard from './RecetaViewInfoCard.vue'
// import RecetaStatistics from './RecetaStatistics.vue'
// import RecetaDetalles from './RecetaDetalles.vue'


export default {
    directives: {
        Ripple,
        "b-toggle": VBToggle,
        "b-modal": VBModal
    },
    filters: {
        title
    },
    components: {
        BRow,
        BCol,
        BCard,
        BCardBody,
        BTableLite,
        BCardText,
        BListGroup,
        BListGroupItem,
        BButton,
        BAlert,
        BLink,
        BBadge,
        BCardFooter,
        BCardSubTitle,
        BFormGroup,
        BImg,


        BCardHeader,

        BFormInput,
        vSelect,
        BFormCheckbox,

        // RecetaViewInfoCard,
        // RecetaStatistics,
        // RecetaDetalles,
    

      
    },
    setup() {
 
        const ACTAS_STORE_MODULE_NAME = "control-actas";

        // Register module
        if (!store.hasModule(ACTAS_STORE_MODULE_NAME))
            store.registerModule(
                ACTAS_STORE_MODULE_NAME,
                actasStoreModule
            );

        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(ACTAS_STORE_MODULE_NAME))
                store.unregisterModule(ACTAS_STORE_MODULE_NAME);
        });


  

        const {
            actaData,
            errorServer,
        } = useActaView(router.currentRoute.params.id);

    
    
        return {
            actaData,
            errorServer,
          



     
        };
    }
};
</script>

<style lang="scss" scoped>
@import "~@core/scss/base/pages/app-invoice.scss";
.logo-header {
        width: 100px;
        height: 100px;
    }

.p {
  font-weight: bold;
}
</style>

<style lang="scss">
@media print {
    // Global Styles
    body {
        background-color: transparent !important;
    }
    nav.header-navbar {
        display: none;
    }
    .main-menu {
        display: none;
    }
    .header-navbar-shadow {
        display: none !important;
    }
    .content.app-content {
        margin-left: 0;
        padding-top: 2rem !important;
    }
    footer.footer {
        display: none;
    }
    .card {
        background-color: transparent;
        box-shadow: none;
    }
    .customizer-toggle {
        display: none !important;
    }

    // Invoice Specific Styles
    .invoice-preview-wrapper {
        .row.invoice-preview {
            .col-md-8 {
                max-width: 100%;
                flex-grow: 1;
            }

            .invoice-preview-card {
                .card-body:nth-of-type(2) {
                    .row {
                        > .col-12 {
                            max-width: 50% !important;
                        }

                        .col-12:nth-child(2) {
                            display: flex;
                            align-items: flex-start;
                            justify-content: flex-end;
                            margin-top: 0 !important;
                        }
                    }
                }
            }
        }

        // Action Right Col
        .invoice-actions {
            display: none;
        }
    }
}

.bomberos>.card-header>.collapse-title:hover {
  color: #F25C05;
}

    
</style>
