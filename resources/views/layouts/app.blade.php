<!Doctype html>
<html lang="en">
<head>
    @include('layouts.partials.head')
    @stack('styles')
</head>
<body>
@include('layouts.leftSidebar')
@include('layouts.header')
<!-- Begin page -->
<div class="page-wrapper">
    <div class="page-content-tab">
        <div class="container-fluid">
            @include('layouts.breadcrumb',['title' => $title ?? ''])
            @section('main-content')
            @show
            <!-- End Page-content -->
            @include('layouts.footer')
            <!-- end main content-->
        </div>
    </div>
</div>
@include('layouts.partials.scripts')
@stack('scripts')
</body>
</html>
