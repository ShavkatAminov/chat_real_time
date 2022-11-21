<template>
  <li @click="select" class="list-group-item" :class="{active: user.active}">
    <span class="badge badge-pill badge-success online" v-if="online">&nbsp;</span>
    {{user.email}}
  </li>
</template>

<script>
export default {
  name: "UserItem",
  props: {
    user: {
      id: Number,
      email: String,
      active: Boolean,
    },
    online: Boolean,
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
