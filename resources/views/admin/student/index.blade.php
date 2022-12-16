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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-user-graduate"></span>
                                Student</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Student</li>
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
                            <a class="btn btn-sm bg1" href="#" data-toggle="modal" data-target="#add"><i
                                    class="fa fa-user-plus"></i> Add Student</a><br><br>
                            <div class="col-md-12 table-responsive">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID No.</th>
                                            <th>Profile</th>
                                            <th>Complete Name</th>
                                            <th>Email</th>
                                            <th>Account Status</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach($students as $student)
                                        <tr>
                                            <td>{{$student->id}}</td>
                                            <td><img src="EMS/asset/img/avatar.png" width="40"
                                                    style="border-radius:10px" alt="User Image"></td>
                                            <td>{{$student->name}}</td>
                                            <td>{{$student->email}}</td>
                                            <td><span class="badge bg-success">active</span></td>
                                            <td class="text-right">
                                                <a class="btn btn-sm bg3" href="#"><i class="fa fa-edit"></i>
                                                    edit</a>
                                                <a class="btn btn-sm bg1" href="#" data-toggle="modal"
                                                    data-target="#delete"><i class="fa fa-trash-alt"></i> delete</a>
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
    <div id="delete" class="modal animated rubberBand delete-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="../asset/img/sent.png" alt="" width="50" height="46">
                    <h3>Are you sure want to delete this Student?</h3>
                    <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn bg1">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="add" class="modal animated rubberBand delete-modal " role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <form>
                        <div class="card-body">
                            <div class="row">
                                {{-- <div class="col-md-12 float-left">
                                    <div class="float-left">
                                        <span class="fa fa-user"> Profile Information</span>
                                    </div>
                                </div> --}}

                                {{-- <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="float-left">ID No.</label>
                                        <input type="email" class="form-control" placeholder="ex. 123-23432-12">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="float-left">First Name</label>
                                        <input type="email" class="form-control" placeholder="first name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="float-left">Middle Name</label>
                                        <input type="email" class="form-control" placeholder="middle name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="float-left">Last Name</label>
                                        <input type="email" class="form-control" placeholder="last name">
                                    </div>
                                </div> --}}
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="float-left">Course</label>
                                        <select class="form-control">
                                            <option>Course 1</option>
                                            <option>Course 2</option>
                                        </select>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="float-left">Profile</label>
                                        <input type="file" class="form-control">
                                    </div>
                                </div> --}}

                                <div class="col-md-12">
                                    <div class="float-left">
                                        <span class="fa fa-user-lock"> Account</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="float-left">Username</label>
                                        <input type="email" class="form-control" placeholder="username">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="float-left">Email</label>
                                        <input type="email" class="form-control" placeholder="ex. john@gmail.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="float-left">Password</label>
                                        <input type="email" class="form-control" placeholder="**********">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn bg2">Save</button>
                            <button type="submit" class="btn bg1">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    @include('admin.partials.footer')
    <script>
        $(function() {
            $("#example1").DataTable();
        });
    </script>
</body>

</html>
