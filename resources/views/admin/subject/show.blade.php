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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-book"></span> Results
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
                        <div class="card-body">
                            <h4 class="text-center font-weight-bold">Registered Students ({{$subject->name}})</h4>
                            <div class="table-responsive">
                                <table class="table" id="example1">
                                    <thead>
                                        <tr>
                                            <th>Sn.</th>
                                            <th>Student</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="font-weight-bold">{{ $student->name}}</td>
                                                <td>
                                                    <a href="{{route('admin.student.index')}}" class="btn btn-lg btn-primary"><i
                                                        class="fa fa-eye"></i></a>
                                                    <form action="{{ route('admin.student.subject.delete', $subject->id) }}"
                                                        method="post" style="display: inline-block">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" value="{{$student->id}}" name="student">
                                                        <button class="btn  bg1 text-white" type="submit"
                                                            onclick="return confirm('Are you sure?')"><i
                                                                class="fa fa-trash-alt text-white"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!-- form start -->

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
    </script>
</body>

</html>
