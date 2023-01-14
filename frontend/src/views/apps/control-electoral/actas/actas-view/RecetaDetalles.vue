<template>
  <b-card
    v-if="recetaData"
    no-body
    class=""
  >
  <b-tabs class="px-1 mt-1">
                <b-tab>
                    <template #title>
                        <h4>Ingredientes</h4>
                    </template>
                    <b-card-body>
                            
                        <div class="d-flex flex-column">
                                
                            <app-collapse class="" v-if="recetaData.ingredientes.length > 0">
                             
            
                                <app-collapse-item  
                                    v-for="(ingrediente, index) in recetaData.ingredientes"
                                    :key="index"
                                    class="bomberos" :title="'• '+ingrediente.ingrediente.nombre"
                                >
                                    
                                        <div v-if="ingrediente.cantidad">
                                            <span class="ml-1">
                                                Cantidad:
                                            </span>
                                            {{ ingrediente.cantidad }}
                                            {{ ingrediente.unidad }}
                                        </div>
                                        
                                        <div v-if="ingrediente.observacion">
                                            <span class="ml-1">
                                                Obervación:
                                            </span>
                                                {{ ingrediente.observacion }}
                                        </div>

                                    </app-collapse-item>

                         
                            </app-collapse>
                            <div v-else class="mt-1">
                                    <span class="ml-1 mt-1 text-muted">No se registraron ingredientes</span>
                            </div>
                        </div>
            
                    </b-card-body>

                </b-tab>

                <b-tab>
                    <template #title>
                        <h4>Preparación</h4>
                    </template>
                    <div class="mt-3 ml-2" v-if="recetaData.preparacion" v-html="recetaData.preparacion"></div>
                </b-tab>

                <b-tab>
                    <template #title>
                        <h4>Imágenes</h4>
                    </template>
                    <b-card-body>
                        <b-row>
                            <b-col
                                md="6"
                                sm="12"
                                v-for="media in recetaData.galeria"
                                :key="media.id"
                            >
                                <b-img
                                    lazy
                                    fluid
                                    class="w-100"
                                    :src="media.url"
                                    :alt="media.name"
                                />
                            </b-col>
                        </b-row>
                    </b-card-body>

                </b-tab>

            </b-tabs>
  </b-card>
</template>

<script>
import {
  BCard, BCardHeader, BCardTitle, BCardText, BCardBody, BRow, BCol, BMedia, BMediaAside, BAvatar, BMediaBody, BLink, 
  BTabs, BTab, BImg
} from 'bootstrap-vue'

import AppCollapse from '@core/components/app-collapse/AppCollapse.vue'
import AppCollapseItem from '@core/components/app-collapse/AppCollapseItem.vue'


export default {
  components: {
    BRow,
    BCol,
    BCard,
    BCardHeader,
    BCardTitle,
    BCardText,
    BCardBody,
    BMedia,
    BAvatar,
    BMediaAside,
    BMediaBody,
    BLink,

    BTabs,
    BTab,
    AppCollapse,
    AppCollapseItem,
    BImg
  },
  props: {
    recetaData: {
        type: Object,
        required: true,
    },
  },
}
</script>


<style lang="scss">
.bomberos>.card-header>.collapse-title:hover {
    color: red;
  }
</style>

  