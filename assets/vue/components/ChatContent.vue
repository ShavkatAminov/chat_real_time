<template>
  <div class="chat-content">
    <div class="message-content">
      <message v-for="message in messageList" :message="message"/>
    </div>
    <div class="">
      <form action="#" @submit="send">
        <input v-model="message" type="text" class="form-control">
      </form>
    </div>
  </div>
</template>

<script>
import Message from "@/vue/components/Message";
export default {
  name: "ChatContent",
  components: {Message},

  props: {
    user: {
      id: Number,
    }
  },

  methods: {
    send(event) {
      event.preventDefault();
      let request = {
        'action': 'message',
        'user_id': this.user.id,
        'content': this.message,
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
    setList(data) {
      this.messageList = data;
    }
  },
  watch: {
    user: function (newVal)  {
      this.getList();
    }
  },
  data() {
    return {
      message: '',
      connection: null,
      token: '',
      messageList: [],
    }
  },

  created() {
    this.setToken();
    this.connection = new WebSocket("ws://localhost:8080")

    this.connection.onmessage = (event) => {
      let data = JSON.parse(event.data);
      this[data.method](data.messages);
    }

    this.connection.onopen = (event) => {
      this.setTokenToServer();
      this.getList();
    }

    this.connection.onclose = function (event) {
    }
  }
}
</script>

<style scoped>
.chat-content {
  height: 600px;
}

.message-content {
  height: 90%;
}
</style>
