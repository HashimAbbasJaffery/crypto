<!-- jQuery  -->
<script src="../metrica/js/jquery.min.js"></script>
<script src="../metrica/js/jquery-ui.min.js"></script>
<script src="../metrica/js/bootstrap.bundle.min.js"></script>
<script src="../metrica/js/metismenu.min.js"></script>
<script src="../metrica/js/waves.js"></script>
<script src="../metrica/js/feather.min.js"></script>
<script src="../metrica/js/jquery.slimscroll.min.js"></script>
<script src="../metrica/plugins/apexcharts/apexcharts.min.js"></script>
<script src="../metrica/plugins/apexcharts/irregular-data-series.js"></script>
<script src="../metrica/pages/jquery.crypto-dashboard.init.js"></script>
<!-- App js -->
<script src="../metrica/js/app.js"></script>
@isset($scripts)
    @foreach($scripts as $script)
        <script src="{{asset('frontend/js/'.$script.'.js')}}"></script>
    @endforeach
@endisset
