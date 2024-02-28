import "./bootstrap";

import Vue from 'vue/dist/vue.esm.js';
window.Vue = Vue;

import AutoComplete from "andyh-autocomplete";
import TimePicker from "andyh-timepicker";
import GameList from "./components/GameList.vue";
import AddKey from "./components/AddKey.vue";
import AddKeyGame from "./components/AddKeyGame.vue";
import AddKeyDlc from "./components/AddKeyDlc.vue";
import AddKeyWallet from "./components/AddKeyWallet.vue";
import AddKeySubscription from "./components/AddKeySubscription.vue";
import TitleHeader from "./components/TitleHeader.vue";
// import { ZiggyVue } from 'ziggy-js';
//
// Vue.use(ZiggyVue)

Vue.component("AutoComplete", AutoComplete);
Vue.component("TimePicker", TimePicker);

Vue.component("GameList", GameList);

Vue.component("AddKey", AddKey);

Vue.component("AddKeyGame", AddKeyGame);

Vue.component("AddKeyDlc", AddKeyDlc);

Vue.component("AddKeyWallet", AddKeyWallet);

Vue.component("AddKeySubscription", AddKeySubscription);

Vue.component("TitleHeader", TitleHeader);

window.app = new Vue({
    el: "#app"
});
