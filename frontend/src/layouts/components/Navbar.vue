<template>
    <div class="navbar-container d-flex content align-items-center">
        <!-- Nav Menu Toggler -->
        <ul class="nav navbar-nav d-xl-none">
            <li class="nav-item">
                <b-link class="nav-link" @click="toggleVerticalMenuActive">
                    <feather-icon icon="MenuIcon" size="21" />
                </b-link>
            </li>
        </ul>
        
        <!-- Left Col -->
        <div
            class="bookmark-wrapper align-items-center flex-grow-1 d-none d-lg-flex"
        >
            <dark-Toggler class="d-none d-lg-block" />
        </div>

        <b-navbar-nav class="nav align-items-center ml-auto">
            <notification-dropdown :user-data="userData" />
            <b-nav-item-dropdown
                right
                toggle-class="d-flex align-items-center dropdown-user-link"
                class="dropdown-user"
            >
                <template #button-content>
                    <div class="d-sm-flex d-none user-nav">
                        <p class="user-name font-weight-bolder mb-0">
                            {{ userData.fullName || userData.username }}
                        </p>
                        <span class="user-status">{{ userData.role }}</span>
                    </div>
                    <b-avatar
                        size="40"
                        variant="light-primary"
                        badge
                        :src="userData.avatarURL"
                        :text="avatarText(userData.fullName)"
                        class="badge-minimal"
                        badge-variant="success"
                    />
                </template>

                <!-- <b-dropdown-item
                    :to="{ name: 'pages-profile' }"
                    link-class="d-flex align-items-center"
                >
                    <feather-icon size="16" icon="UserIcon" class="mr-50" />
                    <span>{{ $t("Profile") }}</span>
                </b-dropdown-item> -->

                <!-- <b-dropdown-item link-class="d-flex align-items-center">
          <feather-icon
            size="16"
            icon="MailIcon"
            class="mr-50"
          />
          <span>Inbox</span>
        </b-dropdown-item>

        <b-dropdown-item link-class="d-flex align-items-center">
          <feather-icon
            size="16"
            icon="CheckSquareIcon"
            class="mr-50"
          />
          <span>Task</span>
        </b-dropdown-item>

        <b-dropdown-item link-class="d-flex align-items-center">
          <feather-icon
            size="16"
            icon="MessageSquareIcon"
            class="mr-50"
          />
          <span>Chat</span>
        </b-dropdown-item> -->
                <!-- <b-dropdown-divider />

                <b-dropdown-item
                    v-if="$can('editar', 'perfil_user')"
                    :to="{ name: 'pages-account-setting' }"
                    link-class="d-flex align-items-center"
                >
                    <feather-icon size="16" icon="SettingsIcon" class="mr-50" />
                    <span>{{ $t("Settings") }}</span>
                </b-dropdown-item>

                <b-dropdown-divider /> -->

                <b-dropdown-item
                    link-class="d-flex align-items-center"
                    @click="logout"
                >
                    <feather-icon size="16" icon="LogOutIcon" class="mr-50" />
                    <span>Salir</span>
                </b-dropdown-item>
            </b-nav-item-dropdown>
        </b-navbar-nav>
    </div>
</template>

<script>
import {
    BLink,
    BNavbarNav,
    BNavItemDropdown,
    BDropdownItem,
    BDropdownDivider,
    BAvatar
} from "bootstrap-vue";
import DarkToggler from "@core/layouts/components/app-navbar/components/DarkToggler.vue";
import { initialAbility } from "@/libs/acl/config";
import useJwt from "@/auth/jwt/useJwt";
import { avatarText } from "@core/utils/filter";
import NotificationDropdown from "@core/layouts/components/app-navbar/components/NotificationDropdown.vue";

import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

export default {
    components: {
        BLink,
        BNavbarNav,
        BNavItemDropdown,
        BDropdownItem,
        BDropdownDivider,
        NotificationDropdown,
        BAvatar,

        // Navbar Components
        DarkToggler
    },
    data() {
        return {
            userData: JSON.parse(localStorage.getItem("userData")),
            avatarText
        };
    },
    props: {
        toggleVerticalMenuActive: {
            type: Function,
            default: () => {}
        }
    },
    methods: {
        logout() {
            this.$http.get("/api/auth/logout").then(response => {});
            // Remove userData from localStorage
            // ? You just removed token from localStorage. If you like, you can also make API call to backend to blacklist used token
            localStorage.removeItem(useJwt.jwtConfig.storageTokenKeyName);
            localStorage.removeItem(
                useJwt.jwtConfig.storageRefreshTokenKeyName
            );

            // Remove userData from localStorage
            localStorage.removeItem("userData");

            // Reset ability
            this.$ability.update(initialAbility);

            // Redirect to login page
            this.$router.push({ name: "auth-login" }).then(() => {
                this.$toast({
                    component: ToastificationContent,
                    position: "top-right",
                    props: {
                        title: `Sesión finalizada`,
                        icon: "CoffeeIcon",
                        variant: "success",
                        text: response.data.msg
                    }
                });
            });
        }
    }
};
</script>
