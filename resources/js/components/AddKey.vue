<template>
  <div>
    <label for="Key Type">Key Type:</label>
    <br />
    <input type="radio" id="Game" value="Game" v-model="KeyType" selected />
    <label for="Game">Game</label>
    <br />
    <input type="radio" id="DLC" value="DLC" v-model="KeyType" />
    <label for="DLC">DLC</label>
    <br />
    <!-- <input type="radio" id="Wallet" value="Wallet" v-model="KeyType" />
    <label for="Wallet">Wallet</label>
    <br />
    <input type="radio" id="Subscription" value="Subscription" v-model="KeyType" />
    <label for="Subscription">Subscription</label>
    <br />-->

    <add-key-game v-if="( this.KeyType == 'Game' )" :platforms="this.platforms" :csrf="this.csrf"></add-key-game>
    <add-key-dlc v-if="( this.KeyType == 'DLC' )" :platforms="this.platforms" :csrf="this.csrf"></add-key-dlc>
    <add-key-wallet
      v-if="( this.KeyType == 'Wallet' )"
      :platforms="this.platforms"
      :csrf="this.csrf"
    ></add-key-wallet>
    <add-key-subscription
      v-if="( this.KeyType == 'Subscription' )"
      :platforms="this.platforms"
      :csrf="this.csrf"
    ></add-key-subscription>
  </div>
</template>
<script>
export default {
  props: {
    csrf: {
      required: true
    }
  },
  data() {
    return {
      platforms: [],
      KeyType: ""
    };
  },
  methods: {},
  mounted() {
    axios.get("/platforms/index").then(response => {
      this.platforms = response.data;
    });
  },
  watch: {}
};
</script>
