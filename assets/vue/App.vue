<template>
  <div class="container">
    <user-list/>
  </div>
</template>

<script>

import UserList from "./components/UserList";

export default {
  name: 'App',
  components: {
    UserList
  },

  beforeCreate() {
  },

  created: function() {
  }
}
</script>
