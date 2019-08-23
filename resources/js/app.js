

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
import { Form, HasError, AlertError } from 'vform'

import PerfectScrollbar from 'vue2-perfect-scrollbar'
import 'vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css'

Vue.use(PerfectScrollbar)

import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.component('pagination', require('laravel-vue-pagination'));

import VueRouter from 'vue-router'

Vue.use(VueRouter)

import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
})

let routes = [
    { path: '/', component: require('./components/Dashboard').default },
    { path: '/department', component: require('./components/department/Department').default },
    { path: '/income-source', component: require('./components/incomesource/IncomeSource').default }
]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

Vue.filter('myDate', function (value) {
   return moment(value).format('MMMM Do YYYY');
});

window.Fire = new Vue();

Vue.component('DepartmentEdit-component', require('./components/department/DepartmentEdit').default);
Vue.component('home-component', require('./components/Home').default);



const app = new Vue({
    el: '#app',
    router
});
