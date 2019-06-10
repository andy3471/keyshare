<template>
  <div>
    <input type="hidden" name="_token" v-bind:value="csrf">
    <label for="platform">Platform:</label>
    <select class="form-control" name="platform_id" v-model="selectedPlatform">
      <option
        v-for="platform in platforms"
        v-bind:key="platform.id"
        v-bind:value="platform.id"
      >{{ platform.name }}</option>
    </select>

    <label for="Walletname">Value:</label>
    <autocomplete placeholder id="Wallettype" name="Wallettype" classes="form-control"></autocomplete>

    <label for="key">Key:</label>
    <input name="key" class="form-control" type="text" required>
    <label for="message">Message:</label>
    <textarea name="message" class="form-control" type="text"></textarea>
    <br>
    <input type="submit" class="btn btn-keyshare" value="Add Key">
  </div>
</template>
<script>
export default {
  props: {
    platforms: {
      type: Array,
      required: true
    },
    csrf: {
      required: true
    }
  },
  data() {
    return {
      selectedPlatform: ""
    };
  }
};
</script>