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
                                Question</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.question.index') }}">Home</a></li>
                                <li class="breadcrumb-item active">Question</li>
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
                            <a class="btn btn-sm btn-success" href="{{ route('admin.question.create') }}"><i
                                    class="fa fa-plus"></i> Add Question</a><br><br>
                            <div class="col-md-12 table-responsive">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Question</th>
                                            <th>Type</th>
                                            <th>Points</th>
                                            <th>Options</th>
                                            <th>Answers</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($questions as $question)
                                            <tr>
                                                <td>{{ $question->subject->name }}</td>
                                                <td>{{ $question->question }}</td>
                                                <td>{{ $question->type }}</td>
                                                <td>{{ $question->point }}</td>
                                                <td>
                                                    @foreach ($question->options as $option)
                                                        <li>{{ $option->label }}</li>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($question->options as $key => $option)
                                                        @if ($option->is_correct)
                                                            {{ $option->label }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="text-right">
                                                    <a class="btn btn-sm bg3"
                                                        href="{{ route('admin.question.edit', $question->id) }}"><i
                                                            class="fa fa-edit"></i>
                                                        edit</a>

                                                    <form action="{{ route('admin.question.delete', $question->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-sm bg1" type="submit"
                                                            onclick="return confirm('Are you sure?')" >delete<i class="fa fa-trash-alt"></i></button>
                                                    </form>
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
                    <h3>Are you sure want to delete this Course?</h3>
                    <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn bg1">Delete</button>
                    </div>
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
