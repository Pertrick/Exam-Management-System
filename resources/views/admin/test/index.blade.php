@include('admin.partials.header')
<style>
    .myModal {
        height: 550px;
        overflow-y: auto;
    }
    .simple-pagination {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .simple-pagination a, .simple-pagination span {
        background: none !important;
        border: none !important;
        color: #007bff;
        font-size: 1.2rem;
        padding: 0 6px;
        box-shadow: none;
        line-height: 1;
        vertical-align: middle;
    }
    .simple-pagination span.disabled {
        color: #ccc;
        cursor: not-allowed;
    }
    .simple-pagination input[type="number"] {
        width: 60px;
        display: inline-block;
        margin: 0 6px;
        text-align: center;
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
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <a class="btn btn-sm bg-success" href="{{ route('admin.test.create') }}">
                                        <i class="fa fa-plus"></i> Add Exam
                                    </a>
                                </div>
                                <div class="col-md-4 d-flex justify-content-end align-items-center">
                                    <div class="simple-pagination">
                                        @if ($tests->onFirstPage())
                                            <span class="disabled"><i class="fas fa-chevron-left"></i></span>
                                        @else
                                            <a href="{{ $tests->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a>
                                        @endif
                                        <input type="number" 
                                               id="pageInput" 
                                               value="{{ $tests->currentPage() }}" 
                                               min="1" 
                                               max="{{ $tests->lastPage() }}">
                                        <span>of {{ $tests->lastPage() }}</span>
                                        @if ($tests->hasMorePages())
                                            <a href="{{ $tests->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a>
                                        @else
                                            <span class="disabled"><i class="fas fa-chevron-right"></i></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 table-responsive">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Subjects</th>
                                            <th>Types</th>
                                            <th>No of questions</th>
                                            <th>Duration(secs)</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Pass Mark</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($tests as $test)
                                            <tr>
                                                <td>{{ $test->subject->name }}</td>
                                                <td>{{$test->testType->name}}</td>
                                                <td>{{ $test->questions->count() }}</td>
                                                <td>{{ $test->duration }}</td>
                                                <td>{{$test->start_date }}</td>
                                                <td>{{$test->end_date }}</td>
                                                <td>{{ $test->pass_mark }}</td>

                                                <td class="text-right">
                                                    <button class="{{$test->is_published ?'btn btn-sm btn-warning text-white text-xs' : 'btn btn-sm btn-success text-white text-xs' }}" id="{{$test->id}}"
                                                        onclick="publish({{ $test->id }});">
                                                        {{$test->is_published ? "unpublish" : "publish"}}</button>

                                                    <button type="button" class="btn btn-sm btn-info questions"
                                                        data-id="{{ $test->questions }}" data-toggle="modal"
                                                        data-target="#view-question-modal">
                                                        <i class="fa fa-eye"></i>
                                                    </button>

                                                    <a class="btn btn-sm bg4"
                                                        href="{{ route('admin.test.edit', $test->id) }}"><i
                                                            class="fa fa-edit text-white"></i>
                                                    </a>
                                                    <form action="{{ route('admin.test.export', $test->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-sm btn-secondary" type="submit"><i
                                                                class="fa fa-download text-white"></i></button>
                                                    </form>

                                                    <form action="{{ route('admin.test.delete', $test->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-sm bg1" type="submit"
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body myModal text-center">
                    <label for="options">Questions</label>
                    <div class="row" id="questionrow"></div>

                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.footer')
    <script>
        $('.questions').on('click', function() {
            $('#questionrow').html('');
            var data = $(this).attr('data-id');
            var question = JSON.parse(data);
            var count = 1;
            question.forEach(function(item) {
                var card =
                    `<div class="col-md-12 mb-2 is-select">
                                    <div class="card-group"> 
                                        <div class="card">
                                            <div class="card-body"><h4 class="card-title" style="font-size:x-small"> ${count++}. ${item.question} `
                                                if(item.image != null){
                                                    console.log(item.question.image);
                                                    card +=`<img src="/storage/images/questions/${item.image.name}" class="border" alt="${item.image.name}" width="100" height="50"> `
                                                }else{
                                                    console.log(item);
                                                }
                                               card += `</h4>`;
                                               
                item.options.forEach(function(value, key) {

                    if(value.image == null){
                        
                        if(value.is_correct ==1){
                    card += `<h6 class="card-text" style="font-size: x-small"><li class="text-left rounded-sm p-1 ">${value.label} <i
                                                     class="fa fa-check text-success"></i></li></h6>` 
                }else{
                    card += `<h6 class="card-text" style="font-size: x-small"><li class="text-left">${value.label} <i
                                                     class="fa fa-times text-danger"></i></li></h6>`;
                }
                    }else{
                        if(value.is_correct ==1){
                    card += `<h6 class="card-text" style="font-size: x-small"><li class="text-left  rounded-sm p-1 ">${(value.label) ?? ''}<img src="/storage/images/options/${value.image.name}" alt="${value.image.name}" width="100" height="50"><i
                                                     class="fa fa-check text-success"></i></li></h6>` 
                }else{
                    card += `<h6 class="card-text" style="font-size: x-small"><li class="text-left">${(value.label) ?? ''}<img src="/storage/images/options/${value.image.name}" height="50" width="100"><i
                                                     class="fa fa-times text-danger"></i></li></h6>`;
                }
                    }
                
                });
                card += `
                            </div>                                
                                </div>                             
                            </div>                     
                        </div>`
                $('#questionrow').append(card);
            });
        });
        $(function() {
            $("#example1").DataTable();
        });

        function publish(testId) {
                $.ajax({
                    url: '/admin/exam/publish/' + testId,
                    type: 'GET',
                    success: function(response) {
                        if(response == 1){
                            $("#"+testId).text("unpublish");
                            $("#"+testId).attr("class","btn btn-sm btn-warning text-white");
                           
                           
                        }else{
                            $("#"+testId).text("publish");
                            $("#"+testId).attr("class","btn btn-sm btn-success text-white");
                           
                            
                        }
                    },
            });
        }

        document.getElementById('pageInput').addEventListener('change', function() {
            const page = parseInt(this.value);
            const maxPage = parseInt(this.getAttribute('max'));
            const minPage = parseInt(this.getAttribute('min'));
            
            // Validate the input
            if (isNaN(page) || page < minPage) {
                this.value = minPage;
            } else if (page > maxPage) {
                this.value = maxPage;
            }
            
            // Only proceed if the value is valid
            if (page >= minPage && page <= maxPage) {
                const url = new URL(window.location.href);
                url.searchParams.set('page', this.value);
                window.location.href = url.toString();
            }
        });
    </script>
</body>

</html>
