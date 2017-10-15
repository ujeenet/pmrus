
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.Event = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('resource-list', require('./components/ResourceList.vue'));
Vue.component('add-resource', require('./components/AddResource.vue'));
Vue.component('projects-list', require('./components/ProjectList.vue'));
Vue.component('checkpoints-list', require('./components/CheckpointList.vue'));



const app = new Vue({
    el: '#app'
});
