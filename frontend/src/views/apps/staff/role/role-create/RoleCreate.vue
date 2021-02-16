<template>
  <component :is="roleData === undefined ? 'div' : 'b-card'">


    <!-- User Info: Input Fields -->
    <b-form>
      <b-row>

        <!-- Field: Name -->
        <b-col
          cols="12"
          md="6"
        >
          <b-form-group
            :label="$t('Name')"
            label-for="name"
          >
            <b-form-input
              id="name"
              v-model="roleData.name"
            />
          </b-form-group>
        </b-col>

        <!-- Field: Guard Name -->
        <b-col
          cols="12"
          md="6"
        >
          <b-form-group
            :label="$t('Guard Name')"
            label-for="guard_name"
          >
            <b-form-input
              id="guard_name"
              v-model="roleData.guard_name"
            />
          </b-form-group>
        </b-col>

        <!-- Field: Description -->
        <b-col
          cols="12"
          md="12"
        >
          <b-form-group
            :label="$t('Description')"
            label-for="description"
          >
            <b-form-input
              id="description"
              v-model="roleData.description"
              type="text"
            />
          </b-form-group>
        </b-col>


      </b-row>
    </b-form>

    <!-- PERMISSION TABLE -->
    <b-card
      no-body
      class="border mt-1"
    >
      <b-card-header class="p-1">
        <b-card-title class="font-medium-2">
          <feather-icon
            icon="LockIcon"
            size="18"
          />
          <span class="align-middle ml-50">{{ $t('Permissions') }}</span>
        </b-card-title>
      </b-card-header>
      
      <div class="block overflow-x-auto">
        
          <b-card v-for="(group, groupName) in permisosAgrupados" :key="groupName"  >

              <b-card-title v-text="groupName"></b-card-title>
              
              <b-row class="demo-alignment">
                  
                    <!-- Field: Description -->
                    <b-col
                    v-for="permission in group" :key="permission.id"
                      cols="12"
                      md="3"
                    >
                      <b-form-group
                        :label="permission.name"
                        :label-for="'permiso'+permission.id"
                      >
                        <b-form-checkbox :id="'permiso'+permission.id" :name="'permiso'+permission.id"  :checked="false" />
                      </b-form-group>
                    </b-col>

              </b-row>

          </b-card>
      </div>

    </b-card>

    <!-- Action Buttons -->
    <b-button
      variant="primary"
      class="mb-1 mb-sm-0 mr-0 mr-sm-1"
      :block="$store.getters['app/currentBreakPoint'] === 'xs'"
    >
      {{ $t('Save Changes')}}
    </b-button>
    <b-button
      variant="outline-secondary"
      type="reset"
      :block="$store.getters['app/currentBreakPoint'] === 'xs'"
    >
      {{ $t('Reset')}}
    </b-button>
  </component>
</template>

<script>
import {
  
  BButton, BMedia, BAvatar, BRow, BCol, BFormGroup, BFormInput, BForm, BTable, BCard, BCardHeader, BCardTitle, BFormCheckbox,
} from 'bootstrap-vue'
import { ref, onUnmounted } from '@vue/composition-api'
import vSelect from 'vue-select'
import router from '@/router'
import store from '@/store'
import roleStoreModule from '../roleStoreModule'


export default {
  components: {
      BButton,
    BMedia,
    BAvatar,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BForm,
    BTable,
    BCard,
    BCardHeader,
    BCardTitle,
    BFormCheckbox,
    vSelect,


  },
  data(){
      return {
          permisosList:[]
      }
  },
  methods:{
    groupBy(array, key){
        const result = {}
        array.forEach(item => {
            if (!result[item[key]]){
            result[item[key]] = []
            }
            result[item[key]].push(item)
        })
        return result
    },
    loadPermisos(){
      var me = this
        store.dispatch('app-role/fetchPermisos',{})
        .then(response => {
          console.log('response');
          console.log(response);
          console.log(response.data);
          me.permisosList = response.data 
          })
        .catch(error => {
          console.log('error');
          console.log(error);
          // if (error.response.status === 404) {
          //   console.log(error);
          //   //me.permisosList = []
          // }
        })
    }
  },
  mounted(){
    this.loadPermisos()
  },
  computed: {
    permisosAgrupados(){
        return this.groupBy(this.permisosList, 'group_key');
    },
  },
  setup() {
    
    const blankRoleData = {
      name: '',
      guard_name: 'web',
      description: '',
      permissions:[]
    }
    const roleData = ref(JSON.parse(JSON.stringify(blankRoleData)))

    const USER_APP_STORE_MODULE_NAME = 'app-role'

    // Register module
    if (!store.hasModule(USER_APP_STORE_MODULE_NAME)) store.registerModule(USER_APP_STORE_MODULE_NAME, roleStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(USER_APP_STORE_MODULE_NAME)) store.unregisterModule(USER_APP_STORE_MODULE_NAME)
    })

    return {
      roleData,
      
    }
  },
}
</script>

<style>

</style>
