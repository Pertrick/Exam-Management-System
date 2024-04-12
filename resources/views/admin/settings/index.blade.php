@include('admin.partials.header')
<style>
    .myModal {
        height: 550px;
        overflow-y: auto;
    }
</style>

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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-cog"></span>
                                Settings</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                                <li class="breadcrumb-item active">Settings</li>
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
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                  <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Personalize</a>
                                  <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>
                                  <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>
                                </div>
                              </nav>
                              <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="container m-2">
                                        <form action="{{route('admin.settings.store')}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="color">primary color </label>
                                                {{-- @dd($settings) --}}
                                                <input type="color" value="{{$settings->primary_color}}" name="primary_color" class="form-control"/>
                                            </div>
                                          
                                            <div class="form-group">
                                                <label for="color">secondary color </label>
                                                <input type="color"  value="{{$settings->secondary_color}}" name="secondary_color" class="form-control"/>
                                            </div>

                                            <div class="form-group">
                                                <label for="color">main color </label>
                                                <input type="color"  value="{{$settings->main_color}}" name="main_color" class="form-control"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" value="save" class="btn btn-success " />
                                            </div>
                                    
                                        </form>
                                    </div>
                                   
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div class="container m-2">Coming Soon ...</div>
                                </div>
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                    <div class="container m-2">Coming Soon ...</div>
                                </div>
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
   
    @include('admin.partials.footer')
    <script>
       
    </script>
</body>

</html>
