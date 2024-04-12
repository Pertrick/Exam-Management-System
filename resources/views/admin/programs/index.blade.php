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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-book"></span> Program
                            </h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Program</li>
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
                        <!-- form start -->
                        <form action="{{ route('admin.program.store') }}" method="POST" id="form-subject">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card-header">
                                            <span class="fa fa-book"> Program Information</span>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Program Name</label>
                                                    <input type="hidden" id="program-id" name="id" />
                                                    <input type="text" name="name" id="program-name"
                                                        class="form-control" placeholder="enter program name"
                                                        value="{{ old('name') }}">
                                                    @error('name')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea name="description" id="subject-desc" class="form-control">{{ old('description') }}</textarea>
                                                    @error('description')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn bg2 text-white">Save</button>
                                            <button type="button" onclick="resetForm()" class="btn bg1 text-white" id="cancel">Cancel</button>
                                        </div>
                        </form>
                    </div>

                    <div class="col-md-9 table-responsive" style="border-left: 1px solid #ddd;">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Program Name</th>
                                    <th>Description</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programs as $program)
                                    <tr data-toggle="modal" data-id="{{ $program }}" data-target="#delete">
                                        <td>{{ $program->name }}</td>
                                        <td>{{ $program->description }}</td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-sm btn-info"
                                                onclick="editProgram({{ $program }})"><i
                                                    class="fa fa-edit"></i></button>

                                            <form style="display:inline-block"
                                                action="{{ route('admin.program.delete', $program->id) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm bg1 text-white" type="submit"
                                                    onclick="return confirm('Are you sure?')"><i
                                                        class="fa fa-trash-alt text-white"></i></button>
                                            </form>
                                            {{-- <a class="btn btn-sm bg1" href="#" data-toggle="modal"
                                            data-target="#delete"><i class="fa fa-trash-alt"></i> delete</a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    @include('admin.partials.footer')
    <script>
        $(function() {
            $("#example1").DataTable();
        });


        function resetForm() {
            $('#program-id').val('');
            $('#program-name').val('');
            $('#program-desc').val('');
        }

        function editProgram(program) {
            resetForm();
            $('#program-id').val(program.id);
            $('#program-name').val(program.name);
            $('#program-desc').val(program.description);

        }
    </script>
</body>

</html>
