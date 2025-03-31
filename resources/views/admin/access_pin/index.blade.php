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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-certificate"></span>
                                Access Pins</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.question.index') }}">Home</a></li>
                                <li class="breadcrumb-item active">Access Pins</li>
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
                            <div class="d-flex" style="justify-content:space-between">
                                <a class="btn btn-success" href="{{ route('admin.accesspin.create') }}">
                                    <i class="fa fa-plus"></i> 
                                    Generate Pins
                                </a>

                                <button class="btn btn-sm btn-info" 
                                    title="Print Access Pin" id="print-id" onclick="window.print()">
                                    <i class="fa fa-print"></i>
                                    Print
                                </button>
                            </div>
                          
                            <br><br>
                            <div class="col-md-12 table-responsive">

                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Pin</th>
                                            <th>Serial</th>
                                            <th>Status</th>
                                            <th>Used By</th>
                                            <th>Used On</th>
                                            <th>Created On</th>
                                            <th>Created By</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($pins as $data)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $data->pin }}</td>
                                                <td>{{ $data->serial }}</td>
                                                <td>
                                                    @if ($data->status == 0)
                                                        <span class="badge-success badge">Active</span>
                                                    @else
                                                        <span class="badge-danger badge">Used</span>
                                                    @endif
                                                </td>
                                                @if ($data->usedBy)
                                                    <td onclick="showModal({{ $data->usedBy }})"
                                                        style="text-decoration: underline; cusor:pointer">
                                                        {{ $data->usedBy?->name }}</td>
                                                @else
                                                    <td>{{ $data->usedBy?->name }}</td>
                                                @endif

                                                <td>{{ $data->used_on }}</td>


                                                <td>{{ $data->created_at }}</td>
                                                <td>{{ $data->creator->name }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <div class="modal fade" id="view-user-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">User Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="userDetails"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.footer')
    <script>
         $(function() {
            $("#example1").DataTable();
        

        });
    </script>
</body>

</html>
