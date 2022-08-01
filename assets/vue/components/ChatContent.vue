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
    setList(data) {
      this.messageList = data.messages.map(item => ({
        ...item,
        isSent: ((data.isSenderIsFirst && item.sender_is_first == 1) || (!data.isSenderIsFirst && item.sender_is_first == 0))
      }));
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
    this.setToken();
    this.connection = new WebSocket("ws://localhost:8080")

    this.connection.onmessage = (event) => {
      let data = JSON.parse(event.data);
      this[data.method](data.data);
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
  background-color: #cbd7e0;
  height: 600px;
}

.message-content {
  height: 90%;
}
</style>
