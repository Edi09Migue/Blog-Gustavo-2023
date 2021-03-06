<template>
  <b-card
    no-body
  >
    <b-card-body>
      <b-card-title>{{ $t('Permissions') }}</b-card-title>
      <b-card-sub-title>{{ $t('Permissions of') }} {{ roleData.name }}</b-card-sub-title>
    </b-card-body>
      <div class="block overflow-x-auto">
        <b-card
              v-for="(group, groupName) in permisosAgrupados"
              :key="groupName"
          >
              <b-card-title v-text="groupName"></b-card-title>

              <b-row class="demo-alignment">
                  <!-- Field: Description -->
                  <b-col
                      v-for="permission in group"
                      :key="permission.id"
                      cols="12"
                      md="3"
                  >
                      <b-form-group>
                        {{ permission.name }}
                      </b-form-group>
                  </b-col>
              </b-row>
        </b-card>
      </div>
  </b-card>
</template>

<script>
import {
  BCard, BTable, BCardBody, BCardTitle, BCardSubTitle, 
  BFormCheckbox, BFormGroup, BRow, BCol
} from 'bootstrap-vue'
import { ref } from '@vue/composition-api'
export default {
  components: {
    BCard, BTable, BCardBody, BCardTitle, BCardSubTitle, BFormCheckbox,
     BFormGroup, BRow, BCol
  },
  props: {
    roleData: {
      type: Object,
      required: true,
    },
  },
  computed: {
      permisosAgrupados() {
          return this.groupBy(this.permisosList, "group_key");
      }
  },
  methods:{
    groupBy(array, key) {
          const result = {};
          array.forEach(item => {
              if (!result[item[key]]) {
                  result[item[key]] = [];
              }
              result[item[key]].push(item);
          });
          return result;
      },
  },
  setup(props) {
    const permisosList = ref(props.roleData.permissions)
    
    console.log(permisosList);
    return {
      permisosList  
    }
  },
}
</script>

<style>

</style>
