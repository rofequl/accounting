require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
import {Form, HasError, AlertError} from 'vform'
import PerfectScrollbar from 'vue2-perfect-scrollbar'
import 'vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css'
import datePicker from 'vue-bootstrap-datetimepicker';
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
import Select2 from 'v-select2-component';
import Print from 'vue-print-nb'
import swal from 'sweetalert2'

Vue.component('Select2', Select2);
Vue.use(datePicker);
Vue.use(PerfectScrollbar)


Vue.use(Print);


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
    height: '4px'
})

let routes = [
    {path: '/', component: require('./components/Dashboard').default},
    {path: '/department', component: require('./components/department/Department').default},
    {path: '/income-source', component: require('./components/incomesource/IncomeSource').default},
    {path: '/payment', component: require('./components/payment/Payment').default},
    {path: '/payment-report', component: require('./components/payment/PaymentReport').default},
    {path: '/expenditure', component: require('./components/expenditure/Expenditure').default},
    {path: '/credit', component: require('./components/entry/Credit').default},
    {path: '/debit', component: require('./components/entry/Debit').default},
    {path: '/credit-report', component: require('./components/report/CreditReport').default},
    {path: '/debit-report', component: require('./components/report/DebitReport').default},
    {path: '/balance-sheet', component: require('./components/report/BalanceSheet').default},
]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

Vue.filter('myDate', function (value) {
    return moment(value).format('MMMM Do YYYY');
});

window.Fire = new Vue();

Vue.component('home-component', require('./components/Home').default);


const app = new Vue({
    el: '#app',
    router,
    ready: function () {
        this.fetchTips();
    },
    methods: {
        fetchTips: function () {
            this.$http.get('/api/tips', function (tips) {
                this.$set('tips', tips)
            });
        }

    }
});
