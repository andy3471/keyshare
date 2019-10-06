<template>
  <div>
    <form method="POST" action="/addkey/">
      <input type="hidden" name="_token" v-bind:value="csrf" />

      <input type="hidden" name="_token" v-bind:value="csrf" />
      <label for="platform">Platform:</label>
      <select class="form-control" name="platform_id" v-model="selectedPlatform">
        <option
          v-for="platform in platforms"
          v-bind:key="platform.id"
          v-bind:value="platform.id"
        >{{ platform.name }}</option>
      </select>

      <label for="Walletname">Name:</label>
      <autocomplete
        :autocompleteUrl="'autocomplete/subscription/' + this.selectedPlatform + '/'"
        id="Wallettype"
        name="Wallettype"
        classes="form-control"
      ></autocomplete>

      <label for="key">Key:</label>
      <input name="key" class="form-control" type="text" required />
      <label for="message">Message:</label>
      <textarea name="message" class="form-control" type="text"></textarea>
      <input type="hidden" name="key_type" value="4" />
      <br />
      <input type="submit" class="btn btn-keyshare" value="Add Key" />
    </form>
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
