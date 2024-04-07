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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-book"></span> Subject
                            </h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Subject</li>
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
                        <form action="{{ route('admin.subject.store') }}" method="POST" id="form-subject">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card-header">
                                            <span class="fa fa-book"> Subject Information</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Subject Code</label>
                                                    <input type="text" name="code" id="subject-code"
                                                        class="form-control" placeholder="ex. SBJCT-101-21"
                                                        value="{{ old('code') }}">
                                                    @error('code')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Subject Name</label>
                                                    <input type="text" name="name" id="subject-name"
                                                        class="form-control" placeholder="ex. Mathematics"
                                                        value="{{ old('name') }}">
                                                    @error('name')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Course</label>
                                                    <select name="course" class="form-control" id="course-id">
                                                        <option disabled selected> Select Course</option>
                                                        @foreach ($courses as $course)
                                                            <option value="{{ $course->id }}">{{ $course->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('course')
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
                                            <button type="button" onclick="resetForm()" class="btn bg1  text-white" id="cancel">Cancel</button>
                                        </div>
                        </form>
                    </div>

                    <div class="col-md-9 table-responsive" style="border-left: 1px solid #ddd;">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Course</th>
                                    <th>Description</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subjects as $subject)
                                    <tr data-toggle="modal" data-id="{{ $subject }}" data-target="#delete">
                                        <td>{{ $subject->code }}</td>
                                        <td>{{ $subject->name }}</td>
                                        <td>{{$subject->courses ? $subject->courses->implode('name') : ''}}</td>
                                        <td>{{ $subject->description }}</td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-sm btn-info"
                                                onclick="editSubject({{ $subject }})"><i
                                                    class="fa fa-edit"></i></button>

                                            <form action="{{ route('admin.subject.delete', $subject->id) }}"
                                                method="post" style="display: inline-block">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm bg1 text-white" type="submit"
                                                    onclick="return confirm('Are you sure?')">delete<i
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
    {{-- <div id="delete" class="modal animated rubberBand delete-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="EMS/asset/img/sent.png" alt="" width="50" height="46">
                    <h3>Are you sure want to delete this Subject?</h3>
                    <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn bg1">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- jQuery -->
    @include('admin.partials.footer')
    <script>
        $(function() {
            $("#example1").DataTable();
        });

        function resetForm() {
         
                $('#subject-code').val('');
                $('#subject-name').val('');
                $('#subject-desc').val('');
                $('#course-id').val(' ');
        }

        function editSubject(subject) {
            resetForm();
            $('#subject-code').val(subject.code);
            $('#subject-name').val(subject.name);
            $('#subject-desc').val(subject.description);
            if(subject.courses){
                $('#course-id').val(subject.courses[0].id);
            }
            

        }
    </script>
</body>

</html>
