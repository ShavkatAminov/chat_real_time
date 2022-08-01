<template>
  <div class="row">
    <div class="col-md-3 padding-null">
      <ul class="list-group">
        <user-item @click="select(user)" v-for="user in userList" :user="user">
        </user-item>
      </ul>
    </div>
    <div class="col-md-9 padding-null">
      <chat-content v-if="selectedUser.id !== 0" :user="selectedUser">
      </chat-content>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import UserItem from "@/vue/components/UserItem";
import ChatContent from "@/vue/components/ChatContent";


export default {
  name: 'UserList',
  components: {UserItem, ChatContent},
  props: {
  },
  data() {
    return {
      userList: [],
      selectedUser: {
        id: 0,
      },
    }
  },
  mounted() {
    axios
        .get('/user-list/')
        .then(response => {
          this.userList = response.data.map(item => ({
            ...item,
            active: false
          }));
        })
  },

  methods: {
    select(user) {
      this.userList.forEach(item => {
        item.active = false
      });
      user.active = true;
      this.selectedUser = user;
    }
  },
}
</script>

<style scoped>
.user-list {
  background-color: gray;
}
.padding-null {
  padding: 0;
}
</style>
