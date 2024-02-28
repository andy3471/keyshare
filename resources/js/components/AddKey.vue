<template>
  <div>
    <div v-if="dlcenabled">
      <label for="Key Type">Key Type:</label>
      <br>
      <input
        id="Game"
        v-model="KeyType"
        type="radio"
        value="Game"
        selected
      >
      <label for="Game">Game</label>
      <br>
      <input
        id="DLC"
        v-model="KeyType"
        type="radio"
        value="DLC"
      >
      <label for="DLC">DLC</label>
      <br>
      <!-- <input type="radio" id="Wallet" value="Wallet" v-model="KeyType" />
      <label for="Wallet">Wallet</label>
      <br />
      <input type="radio" id="Subscription" value="Subscription" v-model="KeyType" />
      <label for="Subscription">Subscription</label>
      <br />-->

      <add-key-game
        v-if="( KeyType == 'Game' )"
        :platforms="platforms"
        :csrf="csrf"
      />
      <add-key-dlc
        v-if="( KeyType == 'DLC' )"
        :platforms="platforms"
        :csrf="csrf"
      />
      <add-key-wallet
        v-if="( KeyType == 'Wallet' )"
        :platforms="platforms"
        :csrf="csrf"
      />
      <add-key-subscription
        v-if="( KeyType == 'Subscription' )"
        :platforms="platforms"
        :csrf="csrf"
      />
    </div>
    <div v-else>
      <add-key-game
        :platforms="platforms"
        :csrf="csrf"
      />
    </div>
  </div>
</template>
<script>
export default {
  props: {
    csrf: {
      required: true,
      type: String
    },
    dlcenabled: {
      required: true,
      default: true,
      type: Boolean
    }
  },
  data() {
    return {
      platforms: [],
      KeyType: ""
    };
  },
  watch: {},
  mounted() {
    axios.get("/api/platforms").then(response => {
      this.platforms = response.data;
    });
  },
  methods: {}
};
</script>
