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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-file-word"></span>
                                Upcoming Exams</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Upcoming Exams</li>
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
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="col-md-12 table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Subject</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Duration</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Take Exam</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tests as $test)
                                            <tr>
                                                <td>{{ $test->subject->name }}</td>
                                                <td>{{ $test->duration }} seconds</td>
                                                <td>
                                                    <button type="button" data-target="#confirm" data-toggle="modal"
                                                        class="btn btn-sm bg3" onclick="confirm({{ $test}});">
                                                        <i class="fa fa-file-word"></i> Take Exam</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
        <!-- /.card-body -->
    </div>
    </div>
    <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
    <div id="confirm" class="modal animated rubberBand delete-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="EMS/asset/img/sent.png" alt="" width="50" height="46">
                    <h3>Once you click on Start your time start counting</h3>
                    <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn bg1 start">Start</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    @include('student.partials.footer')
    <script>
        function confirm(test) {
            $('.start').on('click', (e) => {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'student/exam/store',
                    dataType: "json",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        test_id: test.id,
                        duration: test.duration
                    },
                    success: function(data) {
                        if (data == 1) {
                            window.location.href = 'student/exam/show/' + test.id;
                        }

                    }
                });
            });
        }
        $(function() {
            $("#example1").DataTable();
        });
    </script>
</body>

</html>
