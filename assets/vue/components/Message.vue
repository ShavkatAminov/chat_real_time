<template>
<div>
  {{message.content}}
</div>
</template>

<script>
export default {
  name: "Message",
  props: {
    message: {
      content: String,
    }
  },
}
</script>

<style scoped>

</style>
