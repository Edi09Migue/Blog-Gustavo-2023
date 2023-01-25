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
                    &nbsp;
                    <h3 v-if="actaData.estado && actaData.inconsistente" class="text-danger" >
                            Inconsistente
                    </h3>
                </div>

                <div class="mt-1">
                    <strong>Parroquia:</strong>
                    <span>
                        {{ actaData.junta.recinto.parroquia.nombre}}
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
                        {{ actaData.junta.para_select}}
                    </span>
                </div>
            </div>

            <div class="d-flex ml-1 mt-1 justify-content-center">
                <b-row class="d-flex justify-content-center">
                    <b-media no-body>
                        <b-media-aside
                            class="mr-1"
                        >
                            <b-avatar
                                size="28"
                                variant="light-primary"
                            >
                                <feather-icon
                                    size="16"
                                    icon="UserIcon"
                                />
                            </b-avatar>

                        </b-media-aside>
                        <b-media-body class="my-auto">
                            <h5 class="font-weight-bolder mb-0 text-primary">
                                {{  actaData.total_votantes }}
                            </h5>
                            <b-card-text class="font-small-5 mb-0">
                               Votantes
                            </b-card-text>
                        </b-media-body>
                    </b-media>
                    <b-media no-body class="ml-4">
                        <b-media-aside
                            class="mr-1"
                        >
                            <b-avatar
                                size="28"
                                variant="light-secondary"
                            >
                                <feather-icon
                                    size="16"
                                    icon="ArchiveIcon"
                                />
                            </b-avatar>

                        </b-media-aside>
                        <b-media-body class="my-auto">
                            <h5 class="font-weight-bolder mb-0">
                                {{  actaData.votos_blancos }}
                            </h5>
                            <b-card-text class="font-small-5 mb-0">
                               Blancos
                            </b-card-text>
                        </b-media-body>
                    </b-media>
                    <b-media no-body class="ml-4">
                        <b-media-aside
                            class="mr-1"
                        >
                            <b-avatar
                                size="28"
                                variant="light-danger"
                            >
                                <feather-icon
                                    size="16"
                                    icon="ArchiveIcon"
                                />
                            </b-avatar>

                        </b-media-aside>
                        <b-media-body class="my-auto">
                            <h5 class="font-weight-bolder mb-0">
                                {{  actaData.votos_nulos }}
                            </h5>
                            <b-card-text class="font-small-5 mb-0">
                               Nulos
                            </b-card-text>
                        </b-media-body>
                    </b-media>

                    <b-media no-body class="ml-4">
                        <b-media-aside
                            class="mr-1"
                        >
                            <b-avatar
                                size="28"
                                variant="light-info"
                            >
                                <feather-icon
                                    size="16"
                                    icon="HashIcon"
                                />
                            </b-avatar>

                        </b-media-aside>
                        <b-media-body class="my-auto">
                            <h5 class="font-weight-bolder mb-0 text-primary">
                                {{ actaData.totalBNC }}
                            </h5>
                            <b-card-text class="font-small-5 mb-0">
                               BNC
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
                                small
                                responsive
                                :items="actaData.candidatos_acta"
                                :fields="tableDetailColumns"
                                :tbody-tr-class="rowClass"
                            >

                                <template #cell(candidato)="data">
                                    <b-card-text class="text-center">
                                        {{ data.item.candidato.nombre }}
                                    </b-card-text>
                                </template>

                                <template #cell(partido)="data">
                                    <b-card-text class="text-center">
                                        <small>
                                            {{ data.item.candidato.nombre_partido }}
                                        </small>
                                        <small> {{ data.item.candidato.numero_lista }}</small>
                                    </b-card-text>
                                </template>

                                <template #cell(votos)="data">
                                    <b-card-text class="text-center">
                                        {{ data.item.votos }}
                                        </b-card-text>
                                </template>
                         
                            </b-table>


                            <b-card-body  v-if="actaData.total_votos" class="invoice-padding mr-1 d-flex flex-column align-items-end pt-0">

                                <div class="d-flex">
                                    <span class='font-small-5'>Candidatos:</span>
                                    &nbsp;
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ actaData.total_votos }}
                                    </h5>
                                </div>
                                <!-- <div class="ml-1 d-flex">
                                    <span class='font-small-5'>T. BNC: </span>
                                    &nbsp;
                                    <h5 class="font-weight-bolder mb-0 text-primary">
                                        {{ actaData.totalBNC }}
                                    </h5>
                                </div> -->
                            </b-card-body>

                

                            <b-card-body no-body v-if="actaData.ingresada" class="invoice-padding mx-1 d-flex flex-column align-items-end py-0">
                                <small>
                                    <strong>Ingresada:</strong>
                                    <span>{{ actaData.ingresada.name }}</span>
                                </small>
                                <small v-if="actaData.procesada">
                                    <strong>Procesada:</strong>
                                    <span>{{ actaData.procesada }}</span>
                                </small>
                            </b-card-body>

                    

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
      rowClass(item) {
        if (item.candidato_id == 9) { return 'table-success' }
      },
   },


    setup() {
        const tableDetailColumns = [
            { key: "candidato", sortable: false, label: ("Candidato"),  thClass: 'text-center' },
            { key: "partido", sortable: false, label: ("Partido"),  thClass: 'text-center' },
            { key: "votos", sortable: false, label: ("Votos"),  thClass: 'text-center' },
        ];


        return {
            tableDetailColumns,
        
        };
    }
  }
  </script>
  