<template>
  <div class="autocomplete">
    <input
      type="text"
      v-model="gameInput"
      :class="classes"
      :id="id"
      :name="name"
      required
      autocomplete="off"
      :placeholder="placeholder"
      @keydown.down="onArrowDown"
      @keydown.up="onArrowUp"
      @keydown.enter="onEnter"
    >
    <ul v-show="listOpen" class="autocomplete-results">
      <li
        v-for="(game, i) in searchResults"
        :key="i"
        @click="selectGame(game.name)"
        @input="searchGames"
        class="autocomplete-result"
        :class="{ 'is-active': i === arrowCounter }"
      >{{game.name}}</li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    placeholder: {
      type: String,
      required: true
    },
    name: {
      type: String,
      required: true
    },
    id: {
      type: String,
      required: true
    },
    classes: {
      type: String,
      required: true
    },
    autocompleteUrl: {
      type: String,
      default: "/autocomplete/games/"
    }
  },
  data() {
    return {
      listOpen: false,
      gameInput: null,
      searchResults: [],
      arrowCounter: -1
    };
  },
  methods: {
    searchGames() {
      this.$emit("GameName", this.gameInput);
      if (this.gameInput.length > 2) {
        axios.get(this.autocompleteUrl + this.gameInput).then(response => {
          this.searchResults = response.data;
          if (
            this.searchResults.length == 1 &&
            this.searchResults[0].name == this.gameInput
          ) {
            this.listOpen = false;
          } else {
            this.listOpen = true;
          }
        });
      } else {
        this.searchResults = [];
      }
    },
    selectGame(e) {
      this.gameInput = e;
      this.arrowCounter = -1;
      setTimeout(() => {
        this.listOpen = false;
      }, 500);
    },
    handleClickOutside(evt) {
      if (!this.$el.contains(evt.target)) {
        this.listOpen = false;
      }
    },
    onArrowDown(evt) {
      if (this.arrowCounter < this.searchResults.length) {
        this.arrowCounter = this.arrowCounter + 1;
      }
    },
    onArrowUp() {
      if (this.arrowCounter > 0) {
        this.arrowCounter = this.arrowCounter - 1;
      }
    },
    onEnter() {
      this.gameInput = this.searchResults[this.arrowCounter].name;
      this.arrowCounter = -1;
      setTimeout(() => {
        this.listOpen = false;
      }, 500);
    }
  },
  mounted() {
    document.addEventListener("click", this.handleClickOutside);
  },
  destroyed() {
    document.removeEventListener("click", this.handleClickOutside);
  },
  watch: {
    gameInput() {
      this.searchGames();
    }
  }
};
</script>
