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
                    @include('student.modals.portal-modal')
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-tachometer-alt"></span> Dashboard</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
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
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-6 col-sm-6 col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg1 elevation-1"><i class="fas fa-file-word" style="color: rgb(211, 209, 207);"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Number of total subject registered</span>
                                    <span class="info-box-number">
                                        {{auth()->user()->subjects()->count()}}
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-6 col-sm-6 col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg2 elevation-1"><i class="fas fa-file-word" style="color: rgb(211, 209, 207);"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Number of Total Exam</span>
                                    <span class="info-box-number">
                                        {{auth()->user()->tests()->count()}}
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-6 col-sm-6 col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg3 elevation-1"><i class="fas fa-file-word" style="color: rgb(211, 209, 207);"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Number of Passed Exam</span>
                                    <span class="info-box-number">
                                        {{$passed_count}}
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-6 col-sm-6 col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg4 elevation-1"><i class="fas fa-file-word" style="color: rgb(211, 209, 207);"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Number of Failed Exam</span>
                                    <span class="info-box-number">
                                        {{$failed_count}}
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>

                        <div class="card-body">
                            <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="staticBackdropLabel">Kindly choose your preferred subject</h5>
                                
                                    </div>
                                    <div class="modal-body">
                                      <form action="{{route('student.subject.store')}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="subjects[]" id="subjects" multiple>
                                                    <option value="" disabled>--choose subject--</option>
                                                    @if(count(auth()->user()->subjects) == 0)
                                                    @foreach($subjects as $subject)
                                                    <option value="{{$subject->id}}">{{$subject->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="submit" class="btn btn-success">Save</button>
                                                </div>
                                        </div>
                                      
                                      </form>
                                    </div>
                                    <div class="modal-footer"></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                    </div>
                </div>
                <!-- /.row -->
                <!-- /.row (main row) -->
        </div>
        <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="EMS/asset/jquery/jquery.min.js"></script>
    <script src="EMS/asset/js/bootstrap.bundle.min.js"></script>
    <script src="EMS/asset/js/adminlte.js"></script>
    <script src="EMS/asset/js/jquery.multi-select.js"></script>

    <script>
    $(document).ready(function(){
       @if(count(auth()->user()->subjects) == 0)
        $("#staticBackdrop").modal('show');
        $('#subjects').multiSelect();

       @endif
        
    });
    </script>

</body>

</html>