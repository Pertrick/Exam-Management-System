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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-file-word"></span>
                                Select Subject</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{route('student.dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">Select Subject</li>
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
                            <div class="col-md-12 table-responsive">
                                <p>Kindly choose your preferred subject*</p>
                                <form action="{{ route('student.subject.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            @error('subject')
                                            <div class="error text-danger text-bold text-xs">{{ $message }}</div>
                                            @enderror
            
                                            <div class="form-group">
                                                    @foreach ($subjects as $subject)
                                                    <label for="subject">{{$subject->name}}</label>
                                                        <input class="text-lg" type="radio" name="subject"
                                                            id="{{ $subject->id }}" value="{{ $subject->id }}">
                                                    @endforeach
                                                {{-- <select name="subjects" id="subjects" multiple>
                                                <option value="" disabled>--choose subject--</option>
                                                @if (count(auth()->user()->subjects) == 0)
                                                    @foreach ($subjects as $subject)
                                                        <option value="{{ $subject->id }}">
                                                            {{ $subject->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select> --}}
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-center" >
                                            <button type="submit" class="btn btn-success" style="width: 25%;">Submit</button>
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