require('./bootstrap');
require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Vue from 'vue';
window.Vue = require('vue');
window.EventHub  = new Vue();

import Articles from './components/ArticlesComponent.vue';

/*Vue.component('pagination', require('laravel-vue-pagination'));*/
import LaravelVuePagination from 'laravel-vue-tailwind-pagination';
Vue.use(LaravelVuePagination);


import VueAxios from 'vue-axios';
import axios from 'axios';




const app = new Vue({
    el: '#app',
    render: h => h(Articles),
});
