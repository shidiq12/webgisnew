

require('./bootstrap');
window.Vue = require('vue');


require('./sweetallert');
require('./filter');
require('./progressbar');
require('./v-form');
require('./passport');
require('./pagination');
window.Fire = new Vue();

import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

const routes = [
    
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/wisatas', component: require('./components/Wisatas.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    
]

const router = new VueRouter({
    mode: 'history',
    routes
});

const app = new Vue({
    el: '#app',
    router,
    data:{
        search: ''
    },
    methods:{
        searchit: _.debounce(() => {
            Fire.$emit('searching');
        },1000),
    }
});


// jQuery.extend(true, jQuery.fn.datetimepicker.defaults, {
//     icons: {
//       time: 'far fa-clock',
//       date: 'far fa-calendar',
//       up: 'fas fa-arrow-up',
//       down: 'fas fa-arrow-down',
//       previous: 'fas fa-chevron-left',
//       next: 'fas fa-chevron-right',
//       today: 'fas fa-calendar-check',
//       clear: 'far fa-trash-alt',
//       close: 'far fa-times-circle'
//     }
// });
