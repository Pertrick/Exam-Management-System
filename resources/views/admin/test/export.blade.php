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
                            <h1 class="m-0 text-center" style="text-align: center"><span class="fa fa-file-word"></span>
                                {{ $test->subject->name }}</h1>
                                <p style="text-align: center"> ({{ $test->testType->name }})</p>
                                <p style="text-align: center;">Instruction: <span style="font-weight:bold">{{$test->instruction}}</span></p>
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

                                        <p id="seconds-left" class="text-right pr-3" style="text-align: right; padding-right:20px">Duration: <span style="font-weight: bold">
                                            {{ $test->duration }} seconds </span></p>

                                        @foreach ($test->questions as $quest)
                                            <div class="card-body">
                                                <div style="margin-bottom:17px;">
                                                    <h4 class="card-title mb-2" style="margin:2px; float:left ">{{ $loop->iteration }}.
                                                        {!! $quest->question !!}
                                                        @if ($quest->image)
                                                            <div class="m-2">
                                                                <img src="/storage/images/questions/{{ $quest->image->name }}"
                                                                    alt="{{ $quest->image->name }}" height="100"
                                                                    width="200" class="img-fluid border">
                                                            </div>
                                                        @endif
                                                    </h4>
                                                    <div style="text-align: right;"">
                                                        <small style="font-weight:bold">{{ $quest->point }}
                                                            point(s)</small>
                                                    </div>
                                                 
                                                    @foreach ($quest->options as $key => $option)
                                                        <p class="card-text" style="margin-left:5px;">
                                                            @if ($quest->type == $option_type)
                                                                <input type="radio"n ame="{{ $quest->id }}[]"
                                                                    id="answer-id"
                                                                    value="{{ $option->label ?? ($option->image->name ?? '') }}">{{ $option->label }}
                                                                @if ($option->image)
                                                                    <img src="/storage/images/options/{{ $option->image->name }}"
                                                                        alt="{{ $option->image->name }}" height="50"
                                                                        width="100" class="img-fluid border">
                                                                @endif
    
                                                            @elseif($quest->type == $multi_choice_type)
                                                                <input type="checkbox"> {{ $option->label }}
                                                                @if ($option->image)
                                                                    <img src="/storage/images/options/{{ $option->image->name }}"
                                                                        alt="{{ $option->image->name }}" height="50"
                                                                        width="100" class="img-fluid border">
                                                                @endif
                                                            @elseif($quest->type == $no_option)
                                                                <input type="text" style="width:70%; border-top:none; border-right:none; border-left:none" autocomplete="off">
                                                            @endif
                                                        </p>
                                                    @endforeach
                                                </div>
                                               
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
