/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue';
//Importação da biblioteca VueX
import Vuex from 'vuex'

Vue.use(Vuex)
//Instancia do Vuex e criação do objeto que posteriormente será global
const store = new Vuex.Store({
    state: {
        teste: 'Hello, World!'
    }
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('post-component', require('./components/PostComponent.vue').default);
Vue.component('login-component', require('./components/Login.vue').default);
Vue.component('post-admin-component', require('./components/PostAdminComponent.vue').default);
Vue.component('alert-component', require('./components/Alert.vue').default);
Vue.component('paginate-component', require('./components/Paginate.vue').default);
Vue.component('modal-component', require('./components/ModalComponent.vue').default);
Vue.component('alter-component', require('./components/AlterComponent.vue').default);
Vue.component('pesquisar-component', require('./components/PesquisarComponent.vue').default);







/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store
});
