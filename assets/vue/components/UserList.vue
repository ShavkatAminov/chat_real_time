<template>
  <div class="row">
    <div class="col-md-4">
      <div v-for="user of this.userList">
        {{user.name}}
      </div>
    </div>
    <div class="col-md-8">

    </div>
  </div>
</template>

<script>
export default {
  name: "UserList",
  props: {
    userList: [
      {
        name: 'Shavkat',
      },
      {
        name: 'Shavkat2',
      }
    ]
  }
}
</script>

<style scoped>

</style>
