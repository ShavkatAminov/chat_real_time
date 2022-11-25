<template>
  <div class="row">
    <div class="col-md-3 padding-null">
      <ul class="list-group">
        <user-item @click="select(user)" v-for="user in userList" :user="user">
        </user-item>
      </ul>
    </div>
    <div class="col-md-9 padding-null">
      <chat-content @setUserOnlineList="setUserOnlineList($event)" v-if="selectedUser.id !== 0" :user="selectedUser">
      </chat-content>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import UserItem from "@/vue/components/UserItem";
import ChatContent from "@/vue/components/ChatContent";
import User from "@/vue/models/User";


export default {
  name: 'UserList',
  components: {UserItem, ChatContent},
  props: {
  },
  data() {
    return {
      userList: [],
      selectedUser: User,
    }
  },
  mounted() {
    axios
        .get('/user-list/')
        .then(response => {
          response.data.forEach(item => {
            this.userList.push(new User(item.id, item.email));
          });
        })
  },

  methods: {
    select(user) {
      this.userList.forEach(item => {
        item.active = false
      });
      user.active = true;
      this.selectedUser = user;
    },
    setUserOnlineList(data) {
      this.userList.filter((item => data.includes(item.id))).forEach(item => {
        item.online = true;
      })
    },
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
