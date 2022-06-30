<template>
  <div>
    Hello workdkd
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
    console.log('before create APP component');
  }
}
</script>
