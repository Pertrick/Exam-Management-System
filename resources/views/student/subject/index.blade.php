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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-book"></span> Subject
                            </h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Home</a></li>
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
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @include('student.partials.alert')

                            <div class="m-3">
                                <span class="fa fa-book"> Subject Information</span>
                            </div>
                            <div class="col-md-12 mb-5">
                                <!-- form start -->
                                <form action="{{ route('student.subject.store') }}" method="POST" id="form-subject">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="subject">Subjects</label>
                                            <select name="subject" id="subjects" class="form-control">
                                                <option value="" selected disabled>--choose subject--
                                                </option>
                                                @foreach ($subjects as $subject)
                                                    @if (in_array($subject->id, $user_subjects->pluck('id')->toArray()))
                                                        <option value="{{ $subject->id }}" disabled>
                                                            {{ $subject->name }}</option>
                                                    @else
                                                        <option value="{{ $subject->id }}">
                                                            {{ $subject->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="subject">Pin</label>
                                            <input type="password" name="code" class="form-control"
                                                placeholder="Enter pin" />
                                        </div>
                                        <div class="col-md-4" style="margin-top: 32px">
                                            <input type="submit" class="btn btn-success" value="Save" />
                                        </div>
                                          
                                       
                                    </div>
                                </form>
                            </div>

                            <div class="col-12 table-responsive" style="border-left: 1px solid #ddd;">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Subject Code</th>
                                            <th>Subject Name</th>
                                            <th>Description</th>
                                            {{-- <th class="text-right">Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user_subjects as $user_subject)
                                            <tr data-toggle="modal" data-id="{{ $user_subject }}" data-target="#delete">
                                                <td>{{ $user_subject->code }}</td>
                                                <td>{{ $user_subject->name }}</td>
                                                <td>{{ $user_subject->description }}</td>
                                                {{-- <td class="text-right">
                                                <form action="{{ route('student.subject.delete', $user_subject->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-sm bg1 text-white" type="submit"
                                                        onclick="return confirm('Are you sure?')">delete<i
                                                            class="fa fa-trash-alt text-white"></i></button>
                                                </form>
                                            </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

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
    @include('student.partials.footer')
    <script>
        $(function() {
            $("#example1").DataTable();
        });
        $(document).ready(function() {
            $('#subjects').multiSelect();
        });
    </script>
</body>

</html>
