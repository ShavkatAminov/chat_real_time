<template>
  <li @click="select" class="list-group-item" :class="{active: user.active}">
    <span class="badge badge-pill badge-success online" v-if="user.online">&nbsp;</span>
    {{user.email}}
  </li>
</template>

<script>
import User from "@/vue/models/User";

export default {
  name: "UserItem",
  props: {
    user: User,
  },
  data() {
    return {
    };
  },
  methods: {
  },
  created() {
  }

}
</script>

<style scoped>

</style>
