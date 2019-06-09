<template>
  <div>
    <label for="gamename">Game:</label>
    <autocomplete placeholder id="gamename" name="gamename" classes="form-control"></autocomplete>

    <label for="dlcname">DLC:</label>
    <autocomplete placeholder id="dlcname" name="dlcname" classes="form-control"></autocomplete>

    <label for="platform">Platform:</label>
    <select class="form-control" name="platform_id">
      <option
        v-for="platform in platforms"
        v-bind:key="platform.id"
        v-bind:value="platform.id"
      >{{ platform.name }}</option>
    </select>

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
    }
  }
};
</script>