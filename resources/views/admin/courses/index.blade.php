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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-book"></span> Courses
                            </h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Courses</li>
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
                        <form action="{{ route('admin.course.store') }}" method="POST" id="form-subject">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card-header">
                                            <span class="fa fa-book"> Course Information</span>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Course Name</label>
                                                    <input type="hidden" id="course-id" name="id" />
                                                    <input type="text" name="name" id="course-name"
                                                        class="form-control" placeholder="enter course name"
                                                        value="{{ old('name') }}">
                                                    @error('name')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Capped</label>
                                                    <input type="text" name="capped" id="course-capped-id"
                                                        class="form-control" placeholder="enter course capped"
                                                        value="{{ old('capped') }}">
                                                    @error('capped')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Programs</label>
                                                    <select id="program-id" name="programs[]" multiple>
                                                        @foreach ($programs as $program)
                                                            <option value="{{ $program->id }}">{{ $program->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('description')
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
                                    <th>Course</th>
                                    <th>Capped</th>
                                    <th>Programs</th>
                                    <th>Description</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($courses as $course)
                                    <tr data-toggle="modal" data-id="{{ $course }}" data-target="#delete">
                                        <td>{{ $course->name }}</td>
                                        <td>{{$course->capped}}</td>
                                        <td class="font-weight-bold">{{ $course->programs->implode('name', ',') }}</td>
                                        <td>{{ $course->description }}</td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-sm btn-info"
                                                onclick="editCourse({{ $course }})"><i
                                                    class="fa fa-edit"></i></button>

                                            <form style="display:inline-block"
                                                action="{{ route('admin.course.delete', $course->id) }}"
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
           const programs =  $('#program-id').filterMultiSelect();
        $(function() {
            $("#example1").DataTable();
        

        });

        resetForm();

        function resetForm() {
                $('#course-id').val('');
                $('program-id').val('');
                $('#course-name').val('');
                $('#course-capped-id').val('');
                $('#course-desc').val('');
                programs.deselectAll();
        }

        function editCourse(course) {

            resetForm();
            programs.deselectAll();
            $.each(course.programs, function(key, program) {
                console.log(program.id);
                programs.selectOption(program.id);
            });

            $('#course-id').val(course.id);
            $('#course-name').val(course.name);
            $('#course-capped-id').val(course.capped);
            $('#course-desc').val(course.description);

        }
    </script>
</body>

</html>
