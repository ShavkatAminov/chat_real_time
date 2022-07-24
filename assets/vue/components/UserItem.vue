<template>
  <li @click="select" class="list-group-item" :class="{active: user.active}">
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
    }
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
