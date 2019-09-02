<template>
    <div>
        <div class="main-navbar sticky-top bg-white">
            <!-- Main Navbar -->
            <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
                <ul class="nav main-navbar__search w-100 d-none d-md-flex d-lg-flex py-2">
                    <li class="nav-item">
                        <router-link class="nav-link" style="color: #3d5170" to="/department">Department</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" style="color: #3d5170" to="/income-source">Source of income</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" style="color: #3d5170" to="/expenditure">Expenditure Head</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" style="color: #3d5170" to="/payment">Payment System</router-link>
                    </li>
                </ul>
                <ul class="navbar-nav border-left flex-row ">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle mr-2" src="asset/images/avatars/0.jpg" alt="User Avatar"> <span class="d-none d-md-inline-block"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-small">
                            <a class="dropdown-item text-danger" style="cursor: pointer;" @click="logout">
                                <i class="material-icons text-danger">&#xE879;</i> Logout </a>
                            <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                <input type="hidden" name="_token" :value="token">
                            </form>
                        </div>
                    </li>
                </ul>
                <nav class="nav">
                    <a href="#" class="nav-link nav-link-icon toggle-sidebar d-sm-inline d-md-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                        <i class="material-icons">&#xE5D2;</i>
                    </a>
                </nav>
            </nav>
        </div> <!-- / .main-navbar -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({

                })
            }
        },
        computed: {
            token() {
                let token = document.head.querySelector('meta[name="csrf-token"]');
                return token.content
            }
        },
        methods:{
            logout(){
                document.getElementById('logout-form').submit()
            }
        }
    }
</script>

