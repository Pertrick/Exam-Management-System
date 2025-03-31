<base href="/">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exam Management System</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="EMS/asset/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="EMS/asset/css/adminlte.min.css">
    <link rel="stylesheet" href="EMS/asset/css/style.css">
    <link rel="stylesheet" href="EMS/asset/css/example-styles.css">
    <link rel="stylesheet" href="EMS/asset/tables/datatables-bs4/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="resources-assets/style.css">
    <link rel="stylesheet" href="resources-assets/responsive.css">

    <!--Start of Tawk.to Script-->
{{-- <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/5a5486d1d7591465c7069096/1cdpv4klm';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script> --}}
    <!--End of Tawk.to Script-->
    <script type="text/javascript">
        (function(w, d, v3) {
            w.chaportConfig = {
                appId: '67e668f95dc8f31e23e91e5d'
            };
 
            if (w.chaport) return;
            v3 = w.chaport = {};
            v3._q = [];
            v3._l = {};
            v3.q = function() {
                v3._q.push(arguments)
            };
            v3.on = function(e, fn) {
                if (!v3._l[e]) v3._l[e] = [];
                v3._l[e].push(fn)
            };
            var s = d.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = 'https://app.chaport.com/javascripts/insert.js';
            var ss = d.getElementsByTagName('script')[0];
            ss.parentNode.insertBefore(s, ss)
        })(window, document);
    </script>
 
    <style type="text/css">
        td a.btn {
            font-size: 0.7rem;
        }

        td p {
            padding-left: 0.5rem !important;
        }

        th {
            padding: 1rem !important;
        }

        table tr td {
            padding: 0.3rem !important;
            font-size: 13px;
        }

        .bg1 {
            background-color: rgb(160, 20, 79);
            color: rgb(211, 209, 207);
        }

        .bg2 {
            background-color: rgb(20, 83, 154);
            color: rgb(211, 209, 207);
        }

        .bg3 {
            background-color: rgb(4, 91, 98);
            color: rgb(211, 209, 207);
        }

        nav.mt-2 ul.nav-sidebar li a:hover {
            background-color: {{ $settings->secondary_color }} !important;
        }


        nav.mt-2 ul.nav-sidebar li a.active {
            background-color: {{ $settings->secondary_color }} !important;
        }
    </style>
</head>
