/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
Vue.component("autocomplete", require("./components/Autocomplete.vue").default);

Vue.component("game-list", require("./components/GameList.vue").default);

Vue.component("add-key", require("./components/AddKey.vue").default);

Vue.component("add-key-game", require("./components/AddKeyGame.vue").default);

Vue.component("add-key-dlc", require("./components/AddKeyDlc.vue").default);

Vue.component("add-key-topup", require("./components/AddKeyTopup.vue").default);

Vue.component("title-header", require("./components/Title.vue").default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});
