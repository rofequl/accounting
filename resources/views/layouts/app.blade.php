<!doctype html>
<html class="no-js h-100" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Shards Dashboard Lite - Free Bootstrap Admin Template – DesignRevision</title>
    <meta name="description"
          content="A high-quality &amp; free Bootstrap admin dashboard template pack that comes with lots of templates and components.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/all.css">
</head>
<body class="h-100">
<div class="container-fluid" id="app">
    <div class="row">
        <!-- Main Sidebar -->
    @include('inc.sidebar')
    <!-- End Main Sidebar -->

        <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
            @include('inc.header')
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
            @include('inc.footer')
        </main>
    </div>
</div>

<script src="/js/app.js"></script>
<script src="/js/all.js"></script>
</body>
</html>
