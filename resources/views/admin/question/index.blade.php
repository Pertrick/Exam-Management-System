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
                            <div class="">
                                <a class="btn btn-sm btn-success" href="{{ route('admin.question.create') }}">
                                    <i class="fa fa-plus"></i> Add Question
                                    </a>
                                
                                    <a class="btn btn-sm btn-info d-inline float-right" href="{{ route('admin.question.import') }}">
                                        <i class="fa fa-download"></i>
                                        import
                                    </a>  
                            </div>


                            <br><br>
                            <div class="col-md-12 table-responsive">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Question</th>
                                            <th>Type</th>
                                            <th>Points</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($questions as $question)
                                            <tr>
                                                <td>{{ $question->subject->name }}</td>
                                                <td>
                                                    {{ $question->question }}
                                                    @if (!is_null($question->image))
                                                        <img src="storage/images/questions/{{ $question->image->name }}"
                                                            alt="{{ $question->image->name }}" width="100"
                                                            height="50">
                                                    @endif
                                                </td>
                                                <td>{{ $question->type }}</td>
                                                <td>{{ $question->point }}</td>

                                                <td class="text-right">
                                                    <button type="button" class="btn btn-sm btn-info options"
                                                        data-id ="{{ $question->options }}" data-toggle="modal"
                                                        data-target="#view-options-modal" title="view options">
                                                       <i class="fa fa-eye"></i>
                                                    </button>

                                                    <a class="btn btn-sm bg3 text-white"
                                                        href="{{ route('admin.question.edit', $question->id) }}"
                                                        title="edit"><i class="fa fa-edit text-white"></i>
                                                    </a>

                                                    <form action="{{ route('admin.question.delete', $question->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-sm bg1 text-white" type="submit"
                                                            onclick="return confirm('Are you sure?')"
                                                            title="delete"><i
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
    <div id="view-options-modal" class="modal animated rubberBand delete-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h6>Options</h6>
                    <p id="option-p"></p>
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.footer')
    <script>
        $('.options').on('click', function() {
            $('#option-p').html('');
            var data = $(this).attr('data-id');
            console.log(data);
            var options = JSON.parse(data);
            var label = '';
            options.forEach(element => {
                console.log(element)
                if (element.is_correct == 1) {
                    label += `<h6><li class="text-left rounded-sm p-1 ">${(element.label) ?? ''}`
                    if (element.image != null) {
                        label +=
                            `<img  class="border" src="/storage/images/options/${element.image.name}" alt="${element.image.name}" width="100" height="50">`
                    }
                    label += `<i class="fa fa-check text-success"></i></li></h6>`
                } else {
                    label += `<h6><li class="text-left rounded-sm p-1 ">${(element.label) ?? ''}`
                    if (element.image != null) {
                        label +=
                            `<img class="border" src="/storage/images/options/${element.image.name}" alt="${element.image.name}" width="100" height="50">`
                    }
                    label += `<i class="fa fa-times text-danger"></i></li></h6>`
                }
            });
            $('#option-p').append(label);
        });

        $(function() {
            $("#example1").DataTable();
        });

    </script>
</body>

</html>
