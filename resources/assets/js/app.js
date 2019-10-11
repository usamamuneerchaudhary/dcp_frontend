/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import 'babel-polyfill';

require('./bootstrap');

window.Vue = require('vue');

window.v_tooltip = require('vue-directive-tooltip');
import 'vue-directive-tooltip/src/css/index.scss';
Vue.use(v_tooltip, {
    delay: 50,
});

// window.$ = jQuery; // jQuery - global variable inside your js application.


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('data-table', require('./components/DataTable.vue'));
Vue.component('my-activity', require('./components/MyActivity.vue'));
Vue.component('counter-fiet', require('./components/CounterFiet.vue'));
Vue.component('matched-records', require('./components/MatchedRecords.vue'));
Vue.component('not-matched-records', require('./components/NotMatchedRecords.vue'));
Vue.component('users', require('./components/Users.vue'));
Vue.component('licenses', require('./components/Licenses.vue'));
Vue.component('feedbacks', require('./components/Feedbacks.vue'));
Vue.component('app-download', require('./components/AppDownload.vue'));
Vue.component('members-notification-component', require('./components/MembersNotificationComponent.vue'));
Vue.component('feeback-notification', require('./components/FeedbackNotification.vue'));
Vue.component('pagination', require('./components/Paginator'));


const app = new Vue({
    el: '#app'
});
