<template>
  <b-nav-item-dropdown
    class="dropdown-notification mr-25"
    menu-class="dropdown-menu-media"
    right
    @show="fetchNotifications"
  >
    <template #button-content>
      <feather-icon
        :badge="userData.notifications.length"
        badge-classes="bg-danger"
        class="text-body"
        icon="BellIcon"
        size="21"
      />
    </template>

    <!-- Header -->
    <li class="dropdown-menu-header">
      <div class="dropdown-header d-flex">
        <h4 class="notification-title mb-0 mr-auto">
          {{ $t('Notifications') }}
        </h4>
        <b-badge
          pill
          variant="light-primary"
        >
          {{ notifications.length }}
        </b-badge>
      </div>
    </li>

    <!-- Notifications -->
    <vue-perfect-scrollbar
      :settings="perfectScrollbarSettings"
      class="scrollable-container media-list scroll-area"
      tagname="li"
    >
      <!-- Account Notification -->
      <b-link
        v-for="notification in notifications"
        :key="notification.id"
      >
        <b-media>
          <template #aside>
            <b-avatar
              size="32"
              :src="notification.type"
              :text="notification.type"
              variant="light-info"
            />
          </template>
          <p class="media-heading">
            <span class="font-weight-bolder">
              {{ notification.data.type }}
            </span>
          </p>
          <small class="notification-text">{{ notification.data.resume }}</small>
        </b-media>
      </b-link>
    </vue-perfect-scrollbar> 

    <!-- Cart Footer -->
    <li class="dropdown-menu-footer"><b-button
      v-ripple.400="'rgba(255, 255, 255, 0.15)'"
      variant="primary"
      block
    >Leer todas las notificaciones</b-button>
    </li>
  </b-nav-item-dropdown>
</template>

<script>
import {
  BNavItemDropdown, BBadge, BMedia, BLink, BAvatar, BButton, BFormCheckbox,
} from 'bootstrap-vue'
import VuePerfectScrollbar from 'vue-perfect-scrollbar'
import Ripple from 'vue-ripple-directive'

export default {
  components: {
    BNavItemDropdown,
    BBadge,
    BMedia,
    BLink,
    BAvatar,
    VuePerfectScrollbar,
    BButton,
    BFormCheckbox,
  },
  directives: {
    Ripple,
  },
  data() {
    return {
      notifications: [],
      perfectScrollbarSettings: {
        maxScrollbarLength: 60,
        wheelPropagation: false,
      },
    }
  },
  props: {
    userData: {
      type: Object,
      required: true,
    },
  },
  methods: {
    fetchNotifications() {
      this.$http.get('/api/auth/notifications')
        .then(response => {
          this.notifications = response.data
        })
    },
    markAsRead(notifyId) {
      this.$store.dispatch('app-ecommerce/markAsRead', { notifyId })
        .then(() => {

        })
    },
  },
}
</script>

<style>

</style>
