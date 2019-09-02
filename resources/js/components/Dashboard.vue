<template>
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Dashboard</span>
                <h3 class="page-title">Account Overview</h3>
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Small Stats Blocks -->
        <div class="row">
            <div class="col-12">
                <router-link class="mb-2 btn btn-info mr-2" to="/credit-report">Credit Report</router-link>
                <router-link class="mb-2 btn btn-info mr-2" to="/debit-report">Debit Report</router-link>
                <router-link class="mb-2 btn btn-info mr-2" to="/payment-report">Payment Report</router-link>
                <router-link class="mb-2 btn btn-info mr-2" to="/balance-sheet">Balance Sheet</router-link>
            </div>
            <div class="col-lg-8 mb-4">
                <div class="card card-small lo-stats h-100">
                    <div class="card-header border-bottom">
                        <h6 class="m-0">Latest Report</h6>
                        <div class="block-handle"></div>
                    </div>
                    <div class="card-body p-0">
                        <div class="container-fluid px-0">
                            <table class="table mb-0">
                                <thead class="py-2 bg-light text-semibold border-bottom">
                                <tr class="text-center">
                                    <th>Date</th>
                                    <th>Total Credits</th>
                                    <th class="text-center">Total Debit</th>
                                    <th class="text-center">Profit/Loss</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="balances in balance.data" v-bind:key="balances.id" class="text-center">
                                    <td>{{balances.date}}</td>
                                    <td>{{balances.total_credit}}</td>
                                    <td>{{balances.total_debit}}</td>
                                    <td>{{balances.profit_loss}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        <div class="row">
                            <div class="col">

                            </div>
                            <div class="col text-right view-report">
                                <router-link to="/balance-sheet">View full report &rarr;</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Small Stats Blocks -->
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-12 mb-4">
                        <div class="stats-small card card-small" style="min-height: 5.7rem!important;">
                            <div class="card-body px-0 pb-0">
                                <div class="d-flex px-3">
                                    <div class="stats-small__data">
                                        <span class="stats-small__label mb-1 text-uppercase">Department</span>
                                        <h6 class="stats-small__value count m-0">{{departments.length}}</h6>
                                    </div>
                                    <div class="stats-small__data text-right">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6 col-sm-12 mb-4">
                        <div class="stats-small card card-small" style="min-height: 5.7rem!important;">
                            <div class="card-body px-0 pb-0">
                                <div class="d-flex px-3">
                                    <div class="stats-small__data">
                                        <span class="stats-small__label mb-1 text-uppercase">Total Credit</span>
                                        <h6 class="stats-small__value count m-0">{{credit}}</h6>
                                    </div>
                                    <div class="stats-small__data text-right">
                                    </div>
                                </div>
                                <canvas height="53" class="sales-overview-small-stats-2"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6 col-sm-12 mb-4">
                        <div class="stats-small card card-small" style="min-height: 5.7rem!important;">
                            <div class="card-body px-0 pb-0">
                                <div class="d-flex px-3">
                                    <div class="stats-small__data">
                                        <span class="stats-small__label mb-1 text-uppercase">Total Debit</span>
                                        <h6 class="stats-small__value count m-0">{{debit}}</h6>
                                    </div>
                                    <div class="stats-small__data text-right">
                                    </div>
                                </div>
                                <canvas height="53" class="sales-overview-small-stats-3"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6 col-sm-12 mb-4">
                        <div class="stats-small card card-small" style="min-height: 5.7rem!important;">
                            <div class="card-body px-0 pb-0">
                                <div class="d-flex px-3">
                                    <div class="stats-small__data">
                                        <span class="stats-small__label mb-1 text-uppercase">Total Balance</span>
                                        <h6 class="stats-small__value count m-0">{{total_balance}}</h6>
                                    </div>
                                    <div class="stats-small__data text-right">
                                    </div>
                                </div>
                                <canvas height="53" class="sales-overview-small-stats-4"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Small Stats Blocks -->
            </div>
            <!-- End Small Stats Blocks -->
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                balance: {},
                departments: {},
                credit: {},
                debit: {},
                total_balance: {},
            }
        },
        methods: {
            loadBalance() {
                axios.get('api/balance-sheet').then(({data}) => (this.balance = data));
            },
            loadDepartment() {
                axios.get('api/department-all').then(({data}) => (this.departments = data));
            },
            loadCredit() {
                axios.get('api/total-credit').then(({data}) => (this.credit = data));
            },
            loadDebit() {
                axios.get('api/total-debit').then(({data}) => (this.debit = data));
            },
            loadTotalBalance() {
                axios.get('api/total-balance-sheet').then(({data}) => (this.total_balance = data));
            },
        },
        created() {
            this.loadBalance();
            this.loadDepartment();
            this.loadCredit();
            this.loadDebit();
            this.loadTotalBalance();
            Fire.$on('AfterCreate', () => {
                this.loadBalance();
            });
        },
    }
</script>
