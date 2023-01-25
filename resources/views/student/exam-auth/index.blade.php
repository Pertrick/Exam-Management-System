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
                            <div class="col-md-12 table-responsive">
                                <p class="text-center text-success">Kindly enter your pin to proceed with your exam*</p>
                                <form action="{{ route('student.exam.auth.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            @error('subject')
                                            <div class="error text-danger text-bold text-xs">{{ $message }}</div>
                                            @enderror
                                            <div class="col-md-6 mx-auto text-center">
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="password" placeholder="Enter Pin">
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