<template>
    <div v-if="Object.keys(profileData).length" id="user-profile">
        <profile-header :header-data="profileData.header" />
        <!-- profile info  -->
        <section id="profile-info">
            <b-row>
                <!-- about suggested page and twitter feed -->
                <b-col lg="3" cols="12" order="2" order-lg="1">
                    <profile-about :about-data="profileData.userAbout" />
                </b-col>
                <!--/ about suggested page and twitter feed -->
            </b-row>
        </section>
        <!--/ profile info  -->
    </div>
</template>

<script>
import { BRow, BCol } from "bootstrap-vue";

import ProfileHeader from "./ProfileHeader.vue";
import ProfileAbout from "./ProfileAbout.vue";

/* eslint-disable global-require */
export default {
    components: {
        BRow,
        BCol,

        ProfileHeader,
        ProfileAbout
    },
    data() {
        return {
            profileData: {
                header: {
                    avatar: require("@/assets/images/portrait/small/avatar-s-1.png"),
                    username: "Kitty Allanson",
                    name: "Kitty Allanson",
                    designation: "UI/UX Designer",
                    coverImg: require("@/assets/images/profile/user-uploads/timeline.jpg"),
                    id: -1
                },
                userAbout: {
                    about:
                        "Tart I love sugar plum I love oat cake. Sweet ⭐️ roll caramels I love jujubes. Topping cake wafer.",
                    joined: "November 15, 2015",
                    lives: "New York, USA",
                    email: "bucketful@fiendhead.org",
                    website: "www.pixinvent.com"
                }
            }
        };
    },
    created() {
        this.$http.get("/api/auth/user").then(res => {
            console.log(res);
            console.log(res.data);
            //header
            this.profileData.header.id = res.data.id;
            this.profileData.header.username = res.data.username;
            this.profileData.header.name = res.data.name;
            this.profileData.header.designation = res.data.role;
            this.profileData.header.avatar = res.data.avatarURL;
            this.profileData.header.coverImg = res.data.user_info.portadaURL;
            //userAbout
            this.profileData.userAbout.about = res.data.user_info.bio;
            this.profileData.userAbout.joined = res.data.creado;
            this.profileData.userAbout.email = res.data.email;
            this.profileData.userAbout.website = res.data.user_info.website;
            this.profileData.userAbout.lives = res.data.user_info.ciudad;
        });
    }
};
/* eslint-disable global-require */
</script>

<style lang="scss">
@import "@core/scss/vue/pages/page-profile.scss";
</style>
