<style>
    textarea:focus, input:focus{
    outline: none;
}


</style>
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
                                {{ $test->subject->name }}</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Home</a></li>
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
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-info">
                        <!-- form start -->
                        <form action="{{ route('student.response.store') }}" method="POST" id="form-subject">
                            @csrf
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="card-group">
                                            <div class="card">
                                                <p id="seconds-left" class="text-right pr-3">{{ $test->duration }}
                                                    seconds</p>

                                                @foreach ($test->questions as $quest)
                                                    <div class="card-body">
                                                        <h4 class="card-title mb-2">{{ $sn++ }}.
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
                                                                    <input type="radio"name="{{ $quest->id }}[]"
                                                                        id="answer-id"
                                                                        value="{{ $option->label ?? ($option->image->name ?? '') }}">{{ $option->label }}
                                                                    @if ($option->image)
                                                                        <img src="/storage/images/options/{{ $option->image->name }}"
                                                                            alt="{{ $option->image->name }}"
                                                                            height="50" width="100" class="img-fluid border">
                                                                    @endif

                                                                    <input type="hidden" name="{{ $quest->id }}[]"
                                                                        id="answer-id">
                                                                @elseif($quest->type == $multi_choice_type)
                                                                    <input type="checkbox" name="{{ $quest->id }}[]"
                                                                        id="answer-id"
                                                                        value="{{ $option->label ?? ($option->image->name ?? '') }} ">
                                                                    {{ $option->label }}
                                                                    @if ($option->image)
                                                                        <img src="/storage/images/options/{{ $option->image->name }}"
                                                                            alt="{{ $option->image->name }}"
                                                                            height="50" width="100" class="img-fluid border">
                                                                    @endif
                                                                    <input type="hidden" name="{{ $quest->id }}[]"
                                                                        id="answer-id">
                                                                @elseif($quest->type == $no_option)
                                                                    <textarea class="border-top-0 border-right-0 border-left-0" style="width:100%" name="{{ $quest->id}}[]"
                                                                        id="answer-id" autocomplete="off"></textarea>
                                                                @endif
                                                            </p>
                                                        @endforeach
                                                    </div>
                                                @endforeach

                                                <input type="hidden" value="{{ $test->id }}" name="test_id">
                                            </div>

                                        </div>

                                        <div class="col-md-12 m-3 text-right">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </form>
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
                    <h3>Are you sure want to delete this Result?</h3>
                    <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn bg1">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    @include('student.partials.footer')
    <script>
        var value = $('#seconds-left').text();
        var duration = value.split(' ')[0];

        var refreshId = window.setInterval(function() {
            if (duration > 0) {
                duration--;
            }
            document.getElementById("seconds-left").innerHTML = "Time Left : <strong>" + duration +
                "</strong> seconds";
            if (duration <= 0) {
                $("form").submit();
                clearInterval(refreshId);
            }
        }, 1000);

        $(function() {
            $("#example1").DataTable();
        });
    </script>
</body>

</html>
