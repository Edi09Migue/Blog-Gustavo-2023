<template>
  <b-card
    v-if="countersData"
    no-body
    class=""
  >
    <b-card-body class="statistics-body">
      <b-row class="d-flex justify-content-center">
        <b-col
          v-for="item in countersData"
          :key="item.icon"
          xl="2"
          sm="6"
          md="4"
          :class="item.customClass"
          class="mr-4"
        >
          <b-media no-body>
            <b-media-aside

              class="mr-2"
            >
              <b-avatar
                size="48"
                :variant="item.color"
              >
                <feather-icon
                  size="24"
                  :icon="item.icon"
                />
              </b-avatar>

            </b-media-aside>
            <b-media-body class="my-auto">
              <h4 class="font-weight-bolder mb-0">
                {{ item.title }}
              </h4>
              <b-card-text class="font-small-3 mb-0">
              
                  {{ item.subtitle }}
           
              </b-card-text>
            </b-media-body>
          </b-media>
        </b-col>
      </b-row>
    </b-card-body>
  </b-card>
</template>

<script>
import {
  BCard, BCardHeader, BCardTitle, BCardText, BCardBody, BRow, BCol, BMedia, BMediaAside, BAvatar, BMediaBody, BLink
} from 'bootstrap-vue'

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
  },
  props: {
    countersData: {
    // Le cambie por array 
      type: Array,
      required: true,
    },
  },
}
</script>
