<template>
<div class="chat-content">
  <div class="message-content">
  </div>
  <div class="">
    <form @submit="send">
      <input v-model="message" type="text" class="form-control">
    </form>
  </div>
</div>
</template>

<script>

export default {
  name: "ChatContent",
  props: {
    user: {
      id: Number,
    }
  },

  methods: {
    send() {
      this.connection.send(this.message);
    }
  },
  data() {
    return {
      message: '',
      connection: null,
    }
  },

  created() {
    this.connection = new WebSocket("ws://localhost:8080")

    this.connection.onmessage = (event) =>  {

    }

    this.connection.onopen = (event) =>  {

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
