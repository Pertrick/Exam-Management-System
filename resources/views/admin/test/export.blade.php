
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-file-word"></span>
                                {{ $test->subject->name }}</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">{{ $test->subject->name }}</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content-header --> 
            <!-- /.content -->
                <div class="container-fluid">
                    <div class="card card-info">

                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="card-group">
                                        <div class="card">
                                            <p id="seconds-left" class="text-right pr-3">{{ $test->duration }}
                                                seconds</p>

                                            @foreach ($test->questions as $quest)
                                                <div class="card-body">
                                                    <h4 class="card-title mb-2">{{ $loop->iteration }}.
                                                        {{ $quest->question }}
                                                        @if ($quest->image)
                                                            <div class="m-2">
                                                                <img src="/storage/images/questions/{{ $quest->image->name }}"
                                                                    alt="{{ $quest->image->name }}" height="100"
                                                                    width="200" class="img-fluid border">
                                                            </div>
                                                        @endif
                                                    </h4>
                                                    @foreach ($quest->options as $key => $option)
                                                        <p class="card-text">
                                                            @if ($quest->type == $option_type)
                                                                
                                                                    <p>{{ $option->label }}</p>
                                                                
                                                               
                                                                @if ($option->image)
                                                                    <img src="/storage/images/options/{{ $option->image->name }}"
                                                                        alt="{{ $option->image->name }}" height="50"
                                                                        width="100" class="img-fluid border">
                                                                @endif

                                                            @elseif($quest->type == $multi_choice_type)
                                                                
                                                                    <p>{{ $option->label }}</p>
                                                                
                                                                @if ($option->image)
                                                                    <img src="/storage/images/options/{{ $option->image->name }}"
                                                                        alt="{{ $option->image->name }}" height="50"
                                                                        width="100" class="img-fluid border">
                                                                @endif
                                                              
                                                            @elseif($quest->type == $no_option)
                                                                {{-- <hr style="width:70%"> --}}
                                                            @endif
                                                        </p>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
         
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
</body>

</html>
