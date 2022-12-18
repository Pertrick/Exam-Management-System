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
                                Exam</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.test.index') }}">Home</a></li>
                                <li class="breadcrumb-item active">Exam</li>
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
                            <a class="btn btn-sm btn-success" href="{{ route('admin.test.create') }}"><i
                                    class="fa fa-plus"></i> Add Exam</a><br><br>
                            <div class="col-md-12 table-responsive">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            {{-- <th>Name</th> --}}
                                            <th>Subject</th>
                                            <th>No of questions</th>
                                            <th>Duration(seconds)</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach ($tests as $test)
                                            <tr>
                                                <td>{{ $test->subject->name }}</td>
                                                <td>{{$test->questions->count()}}</td>
                                                <td>{{ $test->duration }}</td>

                                                <td class="text-right">
                                                    <a class="btn btn-sm bg2"
                                                        href="{{ route('admin.test.publish', $test->id) }}"><i
                                                            class="fa fa-edit"></i>
                                                        publish</a>

                                                    <button type="button" class="btn btn-sm btn-info questions"
                                                        data-id={{ $test }} data-toggle="modal"
                                                        data-target="#view-question-modal">
                                                        questions <i class="fa fa-eye"></i>
                                                    </button>

                                                    <a class="btn btn-sm bg4"
                                                        href="{{ route('admin.test.edit', $test->id) }}"><i
                                                            class="fa fa-edit"></i>
                                                        edit</a>

                                                    <form action="{{ route('admin.test.delete', $test->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-sm bg1" type="submit"
                                                            onclick="return confirm('Are you sure?')">delete<i
                                                                class="fa fa-trash-alt"></i></button>
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
    <div id="view-question-modal" class="modal animated rubberBand delete-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="row" id="questionrow"></div>

                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.footer')
    <script>
        $('.questions').on('click', function() {
            // $('.questionrow').html('');
            var data = $(this).attr('data-id');
            console.log(data);
            var question = JSON.parse(data);
            var count = 1;
            question.forEach(function(item) {
                    var card = `<div class="col-md-6 is-select">
                                    <div class="card-group"> 
                                        <div class="card">
                                            <div class="card-body"><h4 class="card-title"> ${count++}. ${item.question}</h4>
                                                <p class="card-text"><li>option</li></p>
                            </div>
                                    <div class="card-footer"> 
                                        <div class="text-left">
                                            <label class="text-right text-xs">*check to select question</label>
                                            <input type="checkbox" name="question_ids[]" value="" >
                                        </div>
                                        <div class="text-right">
                                            <small class="text-muted">Last updated: </small> 
                                        </div>
                                    </div>                                 
                                </div>                             
                            </div>                     
                        </div>`
                    $('#questionrow').append(card);
                });
            // var question = JSON.parse(data);
            // console.log(question);
            // var label = '';
            // options.forEach(element => {
            //     console.log(element)
            //     label += `<li>${element.label}</li>`;
            // });
            // $('#option-p').append(label);
        });
        $(function() {
            $("#example1").DataTable();
        });
    </script>
</body>

</html>
