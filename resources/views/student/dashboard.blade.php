@include('student.partials.header')
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        @include('student.partials.navigation')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('student.partials.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-tachometer-alt"></span> Dashboard</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-6 col-sm-6 col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg1 elevation-1"><i class="fas fa-file-word" style="color: rgb(211, 209, 207);"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Number of Total Exam</span>
                                    <span class="info-box-number">
                                        {{$test_count}}
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-6 col-sm-6 col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg2 elevation-1"><i class="fas fa-file-word" style="color: rgb(211, 209, 207);"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Number of Upcoming Exam</span>
                                    <span class="info-box-number">
                                        5
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-6 col-sm-6 col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg3 elevation-1"><i class="fas fa-file-word" style="color: rgb(211, 209, 207);"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Number of Passed Exam</span>
                                    <span class="info-box-number">
                                        {{$passed_count}}
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-6 col-sm-6 col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg4 elevation-1"><i class="fas fa-file-word" style="color: rgb(211, 209, 207);"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Number of Failed Exam</span>
                                    <span class="info-box-number">
                                        {{$failed_count}}
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <!-- /.row (main row) -->
        </div>
        <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="EMS/asset/jquery/jquery.min.js"></script>
    <script src="EMS/asset/js/adminlte.js"></script>
</body>

</html>