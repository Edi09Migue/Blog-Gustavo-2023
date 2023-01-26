
<template>
  <b-media vertical-align="center">
    <template #aside>
        <b-avatar
            size="32"
            :src="usuario.avatarURL"
            :text="avatarText(usuario.name)"
            variant="light-primary"
            :to="
                $can('ver', 'usuarios')
                    ? {
                          name: 'apps-users-view',
                          params: { id: usuario.persona_id }
                      }
                    : null"
        />
    </template>
    <b-link
        v-if="$can('ver', 'usuarios')"
        :to="{
            name: 'apps-users-view',
            params: { id: usuario.persona_id }
        }"
        class="font-weight-bold d-block text-wrap"
    >
        {{ usuario.name}}
    </b-link>
    <span
        v-else
        class="font-weight-bold d-block text-wrap"
    >
        {{ usuario.name }}
    </span>
    <small class="text-muted text-wrap">
      @{{ usuario.email }}
    </small>
  </b-media>
</template>

<script>

import {BMedia, BLink, BAvatar} from "bootstrap-vue";
import {avatarText} from "@core/utils/filter";

export default {
  components: {
    BMedia,
    BLink,
    BAvatar,
  },
  props: {
    usuario:{
      type: Object,
      required: true
    },
  },
  setup() {
    return {
      avatarText,   
    };
  }
};
</script>
    
