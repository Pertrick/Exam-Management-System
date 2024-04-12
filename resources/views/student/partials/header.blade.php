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
