<template>
<div class="message" :class="{'send': message.isSent, 'received' : !message.isSent}">
  {{message.content}}
</div>
</template>

<script>
export default {
  name: "Message",
  props: {
    message: {
      content: String,
      isSent: Boolean,
    }
  },
  created() {
  }
}
</script>

<style scoped>

.message {
  margin: 15px;
  padding: 10px 15px;
  border-radius: 5px;
}

.received {
  margin-right: 20%;
  background-color: white;
}

.send {
  margin-left: 20%;
  background-color: #0ce10c;
}
</style>
