<template>
  <div
    v-if="(title !== '')"
    class="title"
  >
    <h2>{{ title }}</h2>
  </div>
</template>
<script>
export default {
  props: {
    title: {
      type: String,
      required: true,
      default: ''
    }
  }
};
</script>
