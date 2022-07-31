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
  data() {
    return {
    }
  },
  beforeCreate() {
  },

  created: function() {
  }
}
</script>
