<template>

  <b-card>
      <b-row>

        <b-col
          cols="12"
          xl="4"
          class="d-flex flex-column"
        >

          <div  class="d-flex">
            <img
                :src="recetaData.imagenURL"
                width="300px"
                height="200px"
                />
          </div>
        </b-col>


        <!-- Right Col: Table -->
        <b-col
            cols="3"
            xl="8"
            class="mt-2"
        >
            <!-- <h2>
                {{ recetaData.nombre}} 
            </h2> -->

            <h4>
                <b-badge
                    :variant="recetaData.destacada ? 'light-primary' : 'light-dark'"
                    v-b-tooltip.hover.top="recetaData.destacada ? 'Receta destacada' : ''" 
                >
                    {{ recetaData.nombre }}
                </b-badge>

            </h4>

            <div  class="my-1" v-if="recetaData.descripcion"> {{ recetaData.descripcion }} </div>
            <div>
                <strong>Tipo de Receta:</strong>
                <span class="">
                     {{ recetaData.tipo_receta.nombre}}
                </span>
            </div>
            <div>
                <strong>Especies:</strong>
                <span  v-for="(especie) in recetaData.receta_especie">
                     {{ especie.nombre_comun}}
                </span>
            </div>
        
        </b-col>
    </b-row>
  </b-card>
</template>


<script>
import {
  BCard, BButton, BAvatar, BRow, BCol, BBadge, BTooltip, VBTooltip
} from 'bootstrap-vue'
import { avatarText } from '@core/utils/filter'
import {ref}  from '@vue/composition-api'
export default {
  components: {
    BCard, BButton, BRow, BCol, BAvatar, BBadge, BTooltip
  },

  directives: {
      'b-tooltip': VBTooltip,
  },

   props: {
    recetaData: {
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


 
<style lang="scss" scoped>
    .vehiculo-codigo {
        width: 50%;
    }
</style>
