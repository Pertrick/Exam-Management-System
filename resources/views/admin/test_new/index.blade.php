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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-certificate"></span>
                                Test</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.test.new.create') }}">Home</a></li>
                                <li class="breadcrumb-item active">Test</li>
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
                <div class="container">
                    <h3 class="text-center">Test Dashboard</h3>
                    <a class="btn bg-success mx-3" href="{{ route('admin.test.new.create') }}"><i
                            class="fa fa-plus"></i> Add Test</a>
                        <p class="float-right">{{$tests->count()}} test(s) </p>
                        <form class="my-3" action="{{route('admin.test.new.index')}}" method="GET">
                            <div class="input-group">
                                <input type="search"  value="{{request()->query('search') ?? ''}}" placeholder="search by subject, status, type" style="border:3px solid black" name="search" class="form-control rounded ml-3" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                                <button type="submit" class="btn btn-outline-dark mx-2" data-mdb-ripple-init>search</button>
                              </div>
                        </form>
                    
                    @if (!$tests->isEmpty())
                        <div>
                            <div class="font-weight-bold mb-2 ">
                                <div class="row mx-3 text-md">
                                    <div class="col-md-2">
                                        <span>
                                            <input type="checkbox" id="all" />
                                        </span>
                                    </div>
                                    <div class="col-md-2">
                                        <span>Subjects</span>
                                    </div>
                                    <div class="col-md-2">
                                        <span>Status</span>
                                    </div>
                                    <div class="col-md-2">
                                        <span>Types</span>
                                    </div>
                                    <div class="col-md-2">
                                        <span>Questions</span>
                                    </div>
                                    <div class="col-md-2">
                                        <span>Duration (secs)</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                @foreach ($tests as $test)
                                    <div class="card my-0 mx-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <span><input type="checkbox" id="{{ $test->subject->id }}" /></span>
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="{{ route('admin.test.new.edit', $test->id) }}"
                                                        class="font-weight-bold"
                                                        style="color: rgb(31,108,163);">{{ $test->subject->name }}</a>
                                                    <div class="text-xs">
                                                        @if ($test->start_date && $test->end_date)
                                                            <span>{{ $test->start_date }}</span>/
                                                            <span>{{ $test->end_date }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-2 font-weight-bold">
                                                    <span>{{ $test->is_published ? 'Open' : 'Closed' }}</span>
                                                </div>

                                                <div class="col-md-2 font-weight-bold">
                                                    <span>{{ ucwords($test->testType->name) }}</span>
                                                </div>
                                                <div class="col-md-2 font-weight-bold">
                                                    <a
                                                        href="{{ route('admin.test.new.show', $test->id) }}">{{ $test->questions->count() }}</a>
                                                </div>
                                                <div class="col-md-2 font-weight-bold">
                                                    <span>{{ $test->duration }} sec</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="m-2 d-flex justify-content-center">
                                {{ $tests->links() }}
                            </div>

                        </div>
                        @else
                        <p class="text-center">No test added yet. click on <a class="btn-link text-dark" href="{{ route('admin.test.new.create') }}">add test</a> to add a test!</p>
                        @endif
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
                if (item.image != null) {
                    console.log(item.question.image);
                    card +=
                        `<img src="/storage/images/questions/${item.image.name}" class="border" alt="${item.image.name}" width="100" height="50"> `
                } else {
                    console.log(item);
                }
                card += `</h4>`;

                item.options.forEach(function(value, key) {

                    if (value.image == null) {

                        if (value.is_correct == 1) {
                            card += `<h6 class="card-text" style="font-size: x-small"><li class="text-left rounded-sm p-1 ">${value.label} <i
                                                     class="fa fa-check text-success"></i></li></h6>`
                        } else {
                            card += `<h6 class="card-text" style="font-size: x-small"><li class="text-left">${value.label} <i
                                                     class="fa fa-times text-danger"></i></li></h6>`;
                        }
                    } else {
                        if (value.is_correct == 1) {
                            card += `<h6 class="card-text" style="font-size: x-small"><li class="text-left  rounded-sm p-1 ">${(value.label) ?? ''}<img src="/storage/images/options/${value.image.name}" alt="${value.image.name}" width="100" height="50"><i
                                                     class="fa fa-check text-success"></i></li></h6>`
                        } else {
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
                    if (response == 1) {
                        $("#" + testId).text("unpublish");
                        $("#" + testId).attr("class", "btn btn-sm btn-warning text-white");


                    } else {
                        $("#" + testId).text("publish");
                        $("#" + testId).attr("class", "btn btn-sm btn-success text-white");


                    }
                },
            });
        }
    </script>
</body>

</html>
