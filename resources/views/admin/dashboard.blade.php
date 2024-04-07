@include('admin.partials.header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        @include('admin.partials.navigation')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('admin.partials.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-tachometer-alt"></span>
                                Dashboard</h1>
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
                        <div class="col-xs-12 col-sm-12 col-md-6 ">
                            <div class="info-box">
                                <span class="info-box-icon bg1 elevation-1"><i class="fas fa-chalkboard-teacher"
                                        style="color: rgb(211, 209, 207);"></i></span>

                            <a href="{{ route('admin.program.index') }}" title="students" class="text-dark">
                                <div class="info-box-content">
                                    <span class="info-box-text">Number of Programs</span>
                                    <span class="info-box-number">
                                        {{$program_count}}
                                    </span>
                                </div>
                            </a>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg2 elevation-1"><i class="fas fa-user-graduate"
                                        style="color: rgb(211, 209, 207);"></i></span>

                                <a href="{{ route('admin.student.index') }}" title="students" class="text-dark">
                                    <div class="info-box-content">
                                        <span class="info-box-text">Number of Students</span>
                                        <span class="info-box-number">
                                            {{ $students->count() }}
                                        </span>
                                    </div>
                                </a>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg3 elevation-1"><i class="fas fa-certificate"
                                        style="color: rgb(211, 209, 207);"></i></span>

                            <a href="{{ route('admin.course.index') }}" title="students" class="text-dark">
                                <div class="info-box-content">
                                    <span class="info-box-text">Number of Courses</span>
                                    <span class="info-box-number">{{$course_count}}</span>
                                </div>
                            </a>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg4 elevation-1"><i class="fas fa-book"
                                        style="color: rgb(211, 209, 207);"></i></span>

                                <a href="{{ route('admin.subject.index') }}" title="students" class="text-dark">
                                    <div class="info-box-content">
                                        <span class="info-box-text">Number of Subjects</span>
                                        <span class="info-box-number">{{ $subject_count }}</span>
                                    </div>
                                </a>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-md-6">
                            <!-- USERS LIST -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Latest Students</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <ul class="users-list clearfix">
                                        @foreach ($students as $student)
                                            <li>
                                                <img src="EMS/asset/img/user1-128x128.jpg" alt="User Image">
                                                <a class="users-list-name" href="#">{{ $student->name }}</a>
                                                <span class="users-list-date">{{ $student->created_at }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <!-- /.users-list -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer text-center">
                                    <a href="{{route('admin.student.index')}}">View All Students</a>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!--/.card -->
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="chart-title">
                                        <h4>Student Score Bar Chart</h4><br>
                                    </div>
                                    <canvas id="bargraph"></canvas>
                                </div>
                            </div>
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
    @include('admin.partials.footer')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Bar Chart
            var barChartData = {
                labels: ["Exam 1", "Exam 2", "Exam 3", "Exam 4", "Exam 5"],
                datasets: [{
                        label: 'Passed',
                        backgroundColor: 'rgb(79,129,189)',
                        borderColor: 'rgba(0, 158, 251, 1)',
                        borderWidth: 1,
                        data: [30, 25, 30, 33, 41]
                    },
                    {
                        label: 'Failed',
                        backgroundColor: 'rgb(192,80,77)',
                        borderColor: 'rgba(0, 158, 251, 1)',
                        borderWidth: 1,
                        data: [5, 10, 5, 2, 4]
                    }
                ]
            };

            var ctx = document.getElementById('bargraph').getContext('2d');
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                    legend: {
                        display: true,
                    }
                }
            });

        });
    </script>
</body>

</html>
