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
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content pt-5" >
                <div class="container-fluid">
                    <div class="card card-info ">
                        <div class="card-body">
                            @include('student.partials.alert')
                            <div class="col-md-12 table-responsive">
                                <h2 class="text-center mt-1 mb-3"> Enter Pin </h2>
                                <form action="{{ route('student.exam.auth.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-6 mx-auto text-center">
                                                @error('password')
                                                <div class="error text-danger text-bold text-xs">{{ $message }}</div>
                                                @enderror
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="password" placeholder="Enter Pin">
                                                    <small><i>Kindly enter the pin associated with <b>{{auth()->user()->subjects[0]->name}}</b> to proceed with your exam*</i></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-center" >
                                            <button type="submit" class="btn btn-success" style="width: 25%;">Proceed</button>
                                        </div>
                                    </div>
                                </form>
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
  
    <!-- jQuery -->
    @include('student.partials.footer')
    <script>
        $(function() {
            $("#example1").DataTable();
        });
    </script>
</body>

</html>