<template>
  <div class="title" v-if="(this.title !== '')">
    <h2>{{ this.title }}</h2>
  </div>
</template>
<script>
export default {
  props: {
    title: String
  }
};
</script>
