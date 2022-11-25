<template>
  <div class="chat-content">
    <div class="message-content">
      <message v-for="message in messageList" :message="message"/>
    </div>
    <div class="">
      <form action="#" @submit="send">
        <input v-model="typedText" type="text" class="form-control">
      </form>
    </div>
  </div>
</template>

<script>
import Message from "@/vue/components/Message";
import User from "@/vue/models/User";
export default {
  name: "ChatContent",
  components: {Message},

  emits: ['setUserOnlineList'],
  props: {
    user: User,
  },

  methods: {
    send(event) {
      event.preventDefault();
      let request = {
        'action': 'message',
        'user_id': this.user.id,
        'content': this.typedText,
      };
      this.sendWithStringify(request);
      return false;
    },

    setToken() {
      this.token = document.getElementById('app').getAttribute('data-token');
    },

    setTokenToServer() {
      let request = {
        'action': 'auth',
        'token': this.token,
      };
      this.sendWithStringify(request);
    },

    sendWithStringify(content){
      this.connection.send(JSON.stringify(content));
    },

    getList() {
      this.messageList = [];
      let request = {
        'action': 'list',
        'user_id': this.user.id,
      }
      this.sendWithStringify(request);
    },

    message(data) {
      if(data.user_id == this.user.id) {
        this.messageList.push(data);
        if(data.isSent) {
          this.typedText = '';
        }
      }
    },
    setOnlineList(data) {
      this.$emit('setUserOnlineList', data);
    },
    setList(data) {
      this.messageList = data.messages.map(item => ({
        ...item,
        isSent: ((data.isSenderIsFirst && item.sender_is_first == 1) || (!data.isSenderIsFirst && item.sender_is_first == 0))
      }));
    },
    getOnlineList() {
      setTimeout(() => {
        let request = {
          'action': 'activeList',
        }
        this.sendWithStringify(request);
        this.getOnlineList();
      }, 10000);
    },
    connectionToServer() {
      this.setToken();
      this.connection = new WebSocket("ws://localhost:8080")

      this.connection.onmessage = (event) => {
        let data = JSON.parse(event.data);
        this[data.method](data.data);
      }

      this.connection.onopen = () => {
        this.setTokenToServer();
        this.getList();
        this.getOnlineList();
      }

      this.connection.onclose = () => {
        this.connectionToServer();
      }

      this.connection.onerror = (err) => {
      }
    }
  },
  watch: {
    user: function (newVal)  {
      this.getList();
    }
  },
  data() {
    return {
      typedText: '',
      connection: null,
      token: '',
      messageList: [],
    }
  },

  created() {
    this.connectionToServer();
  }
}
</script>

<style scoped>
.chat-content {
  background-color: #cbd7e0;
  height: 600px;
}

input {
  border: 1px solid black;
}

.message-content {
  overflow-x: auto;
  height: calc(100% - 38px);
}
</style>
