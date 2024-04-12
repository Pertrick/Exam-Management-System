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
                                            <th>Phone</th>
                                            <th>Subject</th>
                                            <th>Account Status</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyId">
                                        @foreach ($students as $student)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><img src="assets/images/user.jpg" width="40"
                                                        style="border-radius:10px" alt="User Image"></td>
                                                <td>{{ $student->name }}</td>
                                                <td>{{ $student->email }}</td>
                                                <td>{{ $student->phone }}</td>
                                                <td>{{ $student->subjects->implode("name",',') }}</td>
                                                <td><span class="badge bg-success">active</span></td>
                                                <td class="text-right">
                                                    <a class="btn btn-sm bg3" href=""><i class="fa fa-edit"></i>
                                                        edit</a>
                                                    <a class="btn btn-sm bg1" href="" data-toggle="modal"
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
                    <form id="add_user">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="float-left">
                                        <span class="fa fa-user-lock"> Account</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="float-left">Username</label>
                                        <input type="name" name="name" class="form-control" id="username"
                                            placeholder="username" value="{{ old('name') }}">
                                    </div>
                                    @error('name')
                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="float-left">Email</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="ex. john@gmail.com" value="{{ old('email') }}" required>
                                    </div>
                                    @error('email')
                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="float-left">Phone</label>
                                        <input type="phone" class="form-control" id="phone" name="phone"
                                            placeholder="Phone" value="{{ old('phone') }}">
                                    </div>
                                    @error('phone')
                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="float-left">Password</label>
                                        <input type="password" name="password" class="form-control" id="password">
                                    </div>
                                    @error('password')
                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="button" id="save_btn" class="btn bg2" value="Save" />
                                    <button type="button" class="btn bg1" data-dismiss="modal">Cancel</button>
                                </div>

                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    @include('admin.partials.footer')
    <script>
        $("#save_btn").click((e) => {
            e.preventDefault();


            if (!$('#username').val()) {
                return;
            }

            if (!$('#email').val()) {
                return;
            }

            if (!$('#password').val()) {
                return;
            }

            const password_confirmation = $("#password").val();
            const serializedData = $("#add_user").serialize() + `&password_confirmation=${password_confirmation}`;


            $.ajax({
                type: 'POST',
                url: '{{ route('auth.register') }}',
                data: serializedData,
                success: function(response) {
                    const user = response.data;
                    console.log(user);
                    const student = `
                    <tr>
                        <td>${ user.id }</td>
                        <td><img src="EMS/asset/img/avatar.png" width="40"
                            style="border-radius:10px" alt="User Image"></td>
                        <td>${user.name }</td>
                        <td>${user.email }</td>
                        <td>${user.phone }</td>
                        <td>${user.subjects ? user.subjects[0].name : '' }</td>
                        <td><span class="badge bg-success">active</span></td>
                        <td class="text-right">
                        <a class="btn btn-sm bg3" href="#"><i class="fa fa-edit"></i>
                                 edit</a>
                        <a class="btn btn-sm bg1" href="#" data-toggle="modal"
                            data-target="#delete"><i class="fa fa-trash-alt"></i> delete</a>
                        </td>
                     </tr>
                    `;

                    $('#tbodyId').append(student);
                    $('#add').modal('hide');

                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $(function() {
            $("#example1").DataTable();
        });
    </script>
</body>

</html>
