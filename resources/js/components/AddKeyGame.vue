<template>
  <div>
    <form method="POST" action="/addkey/store">
      <input type="hidden" name="_token" v-bind:value="csrf" />

      <label for="gamename">Game:</label>
      <autocomplete placeholder v-model="game" url="/autocomplete/games/" id="gamename" name="gamename" classes="form-control"></autocomplete>

      <label for="platform">Platform:</label>
      <select class="form-control" name="platform_id">
        <option
          v-for="platform in platforms"
          v-bind:key="platform.id"
          v-bind:value="platform.id"
        >{{ platform.name }}</option>
      </select>

      <label for="key">Key:</label>
      <input name="key" class="form-control" type="text" required />
      <label for="message">Message:</label>
      <textarea name="message" class="form-control" type="text"></textarea>
      <input type="hidden" name="key_type" value="1" />
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
      game: ""
    };
  }
};
</script>
