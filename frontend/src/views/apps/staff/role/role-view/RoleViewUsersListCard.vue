<template>
    
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
  methods:{

  },
  setup(props) {
    const usersList = ref(props.roleData.usuarios)
    
    console.log(usersList);
    return {
      usersList  
    }
  },
}
</script>

<style>

</style>
