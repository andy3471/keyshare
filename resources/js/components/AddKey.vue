<template>
  <div>
    <label for="Key Type">Key Type:</label>
    <br>
    <input type="radio" id="Game" value="Game" v-model="KeyType" selected>
    <label for="Game">Game</label>
    <br>
    <input type="radio" id="DLC" value="DLC" v-model="KeyType">
    <label for="DLC">DLC</label>
    <br>
    <input type="radio" id="TopUp" value="TopUp" v-model="KeyType">
    <label for="topup">Top Up</label>
    <br>

    <add-key-game v-if="( this.KeyType == 'Game' )" :platforms="this.platforms"></add-key-game>
    <add-key-dlc v-if="( this.KeyType == 'DLC' )" :platforms="this.platforms"></add-key-dlc>
    <add-key-topup v-if="( this.KeyType == 'TopUp' )" :platforms="this.platforms"></add-key-topup>
  </div>
</template>
<script>
export default {
  props: {},
  data() {
    return {
      platforms: [],
      KeyType: ""
    };
  },
  methods: {},
  mounted() {
    axios.get("/platforms/json").then(response => {
      this.platforms = response.data;
    });
  },
  watch: {}
};
</script>
