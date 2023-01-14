<template>
    <b-card
      v-if="actaData"
      no-body
      class=""
    >
      <b-card-body class="statistics-body">

            <div class="d-flex flex-column">      
                <div class="d-flex justify-content-center">
                    <strong>Código:</strong>
                    <span>
                        <b-badge :variant="`light-${actaData.estado ? 'success' : 'primary'}`"> {{ actaData.codigo}} </b-badge>
                    </span>
                </div>

                <div class="mt-1">
                    <strong>Parroquia:</strong>
                    <span>
                        {{ actaData.junta.recinto.parroquia}}
                    </span>
                </div>

                <div>
                    <strong>Recinto:</strong>
                    <span>
                        {{ actaData.junta.recinto.nombre}}
                    </span>
                </div>
                <div>
                    <strong>Junta:</strong>
                    <span>
                        {{ actaData.junta.codigo}}
                    </span>
                </div>
            </div>

            <div class="d-flex ml-1 mt-1 justify-content-center">
                <b-row class="d-flex justify-content-center">
                    <b-media no-body>
                        <b-media-aside
                            class="mr-2"
                        >
                            <b-avatar
                                size="30"
                                variant="light-secondary"
                            >
                                <feather-icon
                                    size="18"
                                    icon="ArchiveIcon"
                                />
                            </b-avatar>

                        </b-media-aside>
                        <b-media-body class="my-auto">
                            <h4 class="font-weight-bolder mb-0">
                                {{  actaData.votos_blancos }}
                            </h4>
                            <b-card-text class="font-small-5 mb-0">
                               Blancos
                            </b-card-text>
                        </b-media-body>
                    </b-media>
                    <b-media no-body class="ml-4">
                        <b-media-aside
                            class="mr-2"
                        >
                            <b-avatar
                                size="30"
                                variant="light-danger"
                            >
                                <feather-icon
                                    size="18"
                                    icon="ArchiveIcon"
                                />
                            </b-avatar>

                        </b-media-aside>
                        <b-media-body class="my-auto">
                            <h4 class="font-weight-bolder mb-0">
                                {{  actaData.votos_nulos }}
                            </h4>
                            <b-card-text class="font-small-5 mb-0">
                               Nulos
                            </b-card-text>
                        </b-media-body>
                    </b-media>
                    <b-media no-body class="ml-4">
                        <b-media-aside
                            class="mr-2"
                        >
                            <b-avatar
                                size="30"
                                variant="light-primary"
                            >
                                <feather-icon
                                    size="18"
                                    icon="ArchiveIcon"
                                />
                            </b-avatar>

                        </b-media-aside>
                        <b-media-body class="my-auto">
                            <h4 class="font-weight-bolder mb-0">
                                {{  actaData.votos_validos }}
                            </h4>
                            <b-card-text class="font-small-5 mb-0">
                               Válidos
                            </b-card-text>
                        </b-media-body>
                    </b-media>
                </b-row>
            </div>

            <div class="mt-2">
                <b-row>
                    <b-col
                            cols="12"
                            xl="12"
                            class="d-flex justify-content-between flex-column"
                        >
                            <b-table
                                responsive
                           
                                :fields="tableDetailColumns"
                                :tbody-tr-class="rowClass"
                            >
                         
                            </b-table>
                    </b-col>
                </b-row>
            </div>
    
      </b-card-body>
    </b-card>
  </template>
  
  <script>
  import {
    BCard, BCardHeader, BCardTitle, BCardText, BCardBody, BRow, BCol, BMedia, BMediaAside, BAvatar, BMediaBody, BLink, BBadge, BTable
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
      BBadge,
      BTable
    },
    props: {
        actaData: {
            type: Object,
            required: true,
        },
    },
    methods: {
      rowClass(item, type) {
        if (!item || type !== 'row') { return }
        if (item.nombre == "Total") { return 'table-success' }
      },
   },


    setup() {
        const tableDetailColumns = [
            { key: "secciones", sortable: true, label: ("Candidato"),  thClass: 'text-center' },
            { key: "puntuacion", sortable: true, label: ("Partido"),  thClass: 'text-center' },
            { key: "total", sortable: true, label: ("Votos"),  thClass: 'text-center' },
        ];


        return {
            tableDetailColumns,
        
        };
    }
  }
  </script>
  