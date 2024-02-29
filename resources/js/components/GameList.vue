<template>
  <div class="gamegrid">
    <div
      v-for="game in games"
      :key="game.id"
      class="gamecard card"
    >
      <a :href="game.url">
        <img
          :src="game.image"
          alt="Card image cap"
          class="image"
        >
        <div class="overlay">{{ game.name }}</div>
      </a>
    </div>
    <infinite-loading
      spinner="waveDots"
      @infinite="infiniteHandler"
    >
      <div slot="no-more" />
      <div slot="no-results">
        No Games Found
      </div>
    </infinite-loading>
  </div>
</template>
<script>
import InfiniteLoading from "vue-infinite-loading";

export default {
  components: {
    InfiniteLoading
  },

  props: {
    url: {
      type: String,
      required: true,
      default: ''
    }
  },
  data() {
    return {
      page: 1,
      lastPage: null,
      games: []
    };
  },
  methods: {
    infiniteHandler($state) {
      axios.get(this.url + "?page=" + this.page).then(response => {
        this.lastPage = response.data.last_page;
        if (this.lastPage >= this.page) {
          this.games = this.games.concat(response.data.data);
          this.page = response.data.current_page + 1;
          $state.loaded();
        } else {
          $state.complete();
        }
      });
    }
  }
};
</script>
