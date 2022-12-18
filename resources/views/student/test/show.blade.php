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
                                {{ $test->subject->name }}</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">{{ $test->subject->name }}</li>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="card-group">
                                        <div class="card">
                                          <p id="seconds-left" class="text-right pr-3">{{$test->duration}} seconds</p>
                                            @foreach ($test->questions as $quest)
                                                <div class="card-body">
                                                    <h4 class="card-title">{{ $sn++ }}. {{ $quest->question }}
                                                    </h4>
                                                    @foreach ($quest->options as $option)
                                                        <p class="card-text">

                                                        <ol type="a">
                                                            <li>{{ $option->label }} <input type="radio"
                                                                    name="answer[]" id="answer-id"
                                                                    value="{{ $option->id }}"></li>

                                                        </ol>

                                                        </p>
                                                    @endforeach
                                                </div>
                                            @endforeach
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
    <div id="delete" class="modal animated rubberBand delete-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="../asset/img/sent.png" alt="" width="50" height="46">
                    <h3>Are you sure want to delete this Result?</h3>
                    <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn bg1">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    @include('student.partials.footer')
    <script>

         var value  = $('#seconds-left').text();
         var duration = value.split(' ')[0];
        window.setInterval(function() {
            if (duration > 0)
                duration--;
            document.getElementById("seconds-left").innerHTML = "Time Left : " + duration + " seconds" ;
            if (duration <= 0)
                duration = 60;
        }, 1000);


        $(function() {
            $("#example1").DataTable();
        });
    </script>
</body>

</html>
