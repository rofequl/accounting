<template>
    <div>
        <div class="row">
            <!-- Main Sidebar -->
            <sidebar></sidebar>
            <!-- End Main Sidebar -->

            <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
                <headers></headers>
                <router-view></router-view>
                <footers></footers>
            </main>
        </div>
    </div>
</template>

<script>
    import sidebar from './inc/Sidebar';
    import headers from './inc/Header';
    import footers from './inc/Footer';
    export default {
        components:{
            sidebar,
            headers,
            footers
        }
    }
</script>

