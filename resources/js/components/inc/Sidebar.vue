<template>
    <div>
        <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
            <div class="main-navbar">
                <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
                    <a class="navbar-brand w-100 mr-0" href="#" style="line-height: 25px;">
                        <div class="d-table m-auto">
                            <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 25px;" src="asset/images/logo.jpg" alt="Shards Dashboard">
                            <span class="d-none d-md-inline ml-1">Army Golf Club</span>
                        </div>
                    </a>
                    <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                        <i class="material-icons">&#xE5C4;</i>
                    </a>
                </nav>
            </div>
            <form action="#" class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">
                <div class="input-group input-group-seamless ml-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    <input class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search">
                </div>
            </form>
            <div class="nav-wrapper">
                <ul class="nav nav--no-borders flex-column">
                    <li class="nav-item">
                        <router-link class="nav-link " to="/">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </router-link>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
                            <i class="material-icons">&#xE917;</i>
                            <span>Credit Setup</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-small">
                            <router-link class="dropdown-item " to="/department">Department</router-link>
                            <router-link class="dropdown-item " to="/income-source">Source of income</router-link>
                        </div>
                    </li>
                </ul>
            </div>
        </aside>
    </div>
</template>

<script>
    export default {
        name: "sidebar"
    }
</script>

<style scoped>

</style>
