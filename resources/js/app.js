import "./bootstrap";

import Vue from 'vue/dist/vue.esm.js';
window.Vue = Vue;

import GameList from "./components/GameList.vue";
import AddKey from "./components/AddKey.vue";
import AddKeyGame from "./components/AddKeyGame.vue";
import AddKeySubscription from "./components/AddKeySubscription.vue";
import TitleHeader from "./components/TitleHeader.vue";
// import { ZiggyVue } from 'ziggy-js';
//
// Vue.use(ZiggyVue)

Vue.component("GameList", GameList);

Vue.component("AddKey", AddKey);

Vue.component("AddKeyGame", AddKeyGame);

Vue.component("AddKeySubscription", AddKeySubscription);

Vue.component("TitleHeader", TitleHeader);

window.app = new Vue({
    el: "#app"
});
