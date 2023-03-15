<template>
  <div>
    <b-card>
        <b-row>
            <b-col md="6">
                <div class="demo-inline-spacing">
                <b-button
                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                    block
                    variant="primary"
                    size="lg"
                    :to="{ name: 'blog-paginas-list'}"
                >
                    <feather-icon
                        icon="BookIcon"
                        size="100"
                       
                    />
                    <h1 class="text-white">
                        Artículos 
                    </h1>
                </b-button>
                </div>
            </b-col>

            <b-col md="6">
            <div class="demo-inline-spacing">
                <b-button
                    v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                    block
                    variant="outline-primary"
                    size="lg"
                    :to="{ name: 'blog-categorias-list'}"
                >
                    <feather-icon
                        icon="ListIcon"
                        size="100"
                       
                    />
                    <h1 class="text-primary">
                        Categorías
                    </h1>
                       
                </b-button>
            </div>
            </b-col>
        </b-row>
    </b-card>
  </div>
</template>

<script>
import { BCard, BCardText, BLink, BRow, BCol, BButton } from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'

export default {
  components: {
    BCard,
    BCardText,
    BLink,
    BRow,
    BCol,
    BButton,
  },
  directives: {
    Ripple,
  },
}
</script>

