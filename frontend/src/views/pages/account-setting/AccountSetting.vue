<template>

  <b-tabs
    vertical
    v-if="userData"
    content-class="col-12 col-md-9 mt-1 mt-md-0"
    pills
    nav-wrapper-class="col-md-3 col-12"
    nav-class="nav-left"
  >

    <!-- general tab -->
    <b-tab active>

      <!-- title -->
      <template #title>
        <feather-icon
          icon="UserIcon"
          size="18"
          class="mr-50"
        />
        <span class="font-weight-bold">{{ $t('General') }}</span>
      </template>

      <account-setting-general
        :general-data="userData"
      />
    </b-tab>
    <!--/ general tab -->

    <!-- change password tab -->
    <b-tab>

      <!-- title -->
      <template #title>
        <feather-icon
          icon="LockIcon"
          size="18"
          class="mr-50"
        />
        <span class="font-weight-bold">{{ $t('Change') }} {{$t('Password') }}</span>
      </template>

      <account-setting-password :user-data="userData" />
    </b-tab>
    <!--/ change password tab -->

    <!-- info -->
    <b-tab>

      <!-- title -->
      <template #title>
        <feather-icon
          icon="InfoIcon"
          size="18"
          class="mr-50"
        />
        <span class="font-weight-bold">{{ $t('Information') }}</span>
      </template>

      <account-setting-information
        :information-data="userData"
      />
    </b-tab>

    <!-- social links -->
    <b-tab>

      <!-- title -->
      <template #title>
        <feather-icon
          icon="LinkIcon"
          size="18"
          class="mr-50"
        />
        <span class="font-weight-bold">{{ $t('Social') }}</span>
      </template>

      <account-setting-social
        v-if="options.social"
        :social-data="options.social"
      />
    </b-tab>

    <!-- notification -->
    <b-tab>

      <!-- title -->
      <template #title>
        <feather-icon
          icon="BellIcon"
          size="18"
          class="mr-50"
        />
        <span class="font-weight-bold">{{ $t('Notifications') }}</span>
      </template>

      <account-setting-notification
        v-if="options.notification"
        :notification-data="options.notification"
      />
    </b-tab>
  </b-tabs>
</template>

<script>
import { BTabs, BTab } from 'bootstrap-vue'
import { ref, onUnmounted } from '@vue/composition-api'
import store from '@/store'
import userStoreModule from '../../apps/staff/user/userStoreModule'
import AccountSettingGeneral from './AccountSettingGeneral.vue'
import AccountSettingPassword from './AccountSettingPassword.vue'
import AccountSettingInformation from './AccountSettingInformation.vue'
import AccountSettingSocial from './AccountSettingSocial.vue'
import AccountSettingNotification from './AccountSettingNotification.vue'

export default {
  components: {
    BTabs,
    BTab,
    AccountSettingGeneral,
    AccountSettingPassword,
    AccountSettingInformation,
    AccountSettingSocial,
    AccountSettingNotification,
  },
  setup() {
    const userData = ref(null)

    const USER_APP_STORE_MODULE_NAME = 'app-user'

    // Register module
    if (!store.hasModule(USER_APP_STORE_MODULE_NAME)) store.registerModule(USER_APP_STORE_MODULE_NAME, userStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(USER_APP_STORE_MODULE_NAME)) store.unregisterModule(USER_APP_STORE_MODULE_NAME)
    })

    store.dispatch('app-user/fetchLoggedUser')
      .then(response => { userData.value = response.data })
      .catch(error => {
        if (error.response.status === 404) {
          userData.value = undefined
        }
      })

    return {
      userData,
    }
  },
  data() {
    return {
      options :{
        
          social: {
            socialLinks: {
              twitter: 'https://www.twitter.com',
              facebook: '',
              google: '',
              linkedIn: 'https://www.linkedin.com',
              instagram: '',
              quora: '',
            },
            connections: {
              twitter: {
                profileImg: require('@/assets/images/avatars/11-small.png'),
                id: 'johndoe',
              },
              google: {
                profileImg: require('@/assets/images/avatars/3-small.png'),
                id: 'luraweber',
              },
              facebook: {},
              github: {},
            },
          },
          notification: {
            commentOnArticle: true,
            AnswerOnForm: true,
            followMe: false,
            newAnnouncements: true,
            productUpdates: true,
            blogDigest: false,
          },
      
      }
    }
  },
 // methods:{
  // created () { 
  //     this.$http.get('/api/auth/user').then(res => {
  //       console.log('res');
  //       console.log(res.data);
  //       this.options.general.username = res.data.username
  //       console.log(this.options.general)
  //       this.options.general.fullName = res.data.name
  //       this.options.general.email = res.data.email
  //       this.options.general.company = res.data.user_info.empresa
          
  //       // this.options.info.about = res.data.bio
  //         this.options.info.dob = res.data.user_info.dob
  //         this.options.info.country = res.data.user_info.pais
  //         this.options.info.website = res.data.user_info.website
  //         this.options.info.phone = res.data.user_info.telefono

  //     })
  //   },
  // mounted(){
  //   this.loadUserData()
  // },
  // setup() {
  //   const options = ref({
        
  //         general: {
  //           avatar: require('@/assets/images/portrait/small/avatar-s-11.jpg'),
  //           username: 'johndoe',
  //           fullName: 'John Doe',
  //           email: 'granger007@hogward.com',
  //           company: 'Crystal Technologies',
  //         },
  //         info: {
  //           bio: '',
  //           dob: null,
  //           country: 'USA',
  //           website: '',
  //           phone: 6562542568,
  //         },
  //         social: {
  //           socialLinks: {
  //             twitter: 'https://www.twitter.com',
  //             facebook: '',
  //             google: '',
  //             linkedIn: 'https://www.linkedin.com',
  //             instagram: '',
  //             quora: '',
  //           },
  //           connections: {
  //             twitter: {
  //               profileImg: require('@/assets/images/avatars/11-small.png'),
  //               id: 'johndoe',
  //             },
  //             google: {
  //               profileImg: require('@/assets/images/avatars/3-small.png'),
  //               id: 'luraweber',
  //             },
  //             facebook: {},
  //             github: {},
  //           },
  //         },
  //         notification: {
  //           commentOnArticle: true,
  //           AnswerOnForm: true,
  //           followMe: false,
  //           newAnnouncements: true,
  //           productUpdates: true,
  //           blogDigest: false,
  //         },
      
  //     })


  //  return {
  //    options
  //  }
  // },
}
/* eslint-disable global-require */
</script>
