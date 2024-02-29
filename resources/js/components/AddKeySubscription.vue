<template>
  <div>
    <form
      method="POST"
      action="/keys/"
    >
      <input
        type="hidden"
        name="_token"
        :value="csrf"
      >

      <input
        type="hidden"
        name="_token"
        :value="csrf"
      >
      <label for="platform">Platform:</label>
      <select
        v-model="selectedPlatform"
        class="form-control"
        name="platform_id"
      >
        <option
          v-for="platform in platforms"
          :key="platform.id"
          :value="platform.id"
        >
          {{ platform.name }}
        </option>
      </select>

      <label for="Walletname">Name:</label>
      <auto-complete
        id="Wallettype"
        :autocomplete-url="'autocomplete/subscription/' + selectedPlatform + '/'"
        name="Wallettype"
        classes="form-control"
      />

      <label for="key">Key:</label>
      <input
        name="key"
        class="form-control"
        type="text"
        required
      >
      <label for="message">Message:</label>
      <textarea
        name="message"
        class="form-control"
        type="text"
      />
      <input
        type="hidden"
        name="key_type"
        value="4"
      >
      <br>
      <input
        type="submit"
        class="btn btn-keyshare"
        value="Add Key"
      >
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
      required: true,
      type: String
    }
  },
  data() {
    return {
      selectedPlatform: ""
    };
  }
};
</script>
