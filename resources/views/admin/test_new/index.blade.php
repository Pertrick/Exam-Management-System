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
    .clear-search-btn {
        background-color: #dc3545 !important;
        color: white !important;
        border: none !important;
        padding: 6px 12px !important;
        margin-left: 5px !important;
        border-radius: 4px !important;
        cursor: pointer !important;
    }
    .clear-search-btn:hover {
        background-color: #c82333 !important;
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
                    <div class="mb-4">
                        <a class="btn bg-success mx-3" href="{{ route('admin.test.new.create') }}"><i
                                class="fa fa-plus"></i> Add Test</a>
                        @if(request('is_archived'))
                            <button id="unarchiveSelected" class="btn btn-warning" disabled>
                                <i class="fas fa-archive"></i> Unarchive Selected
                            </button>
                        @else
                            <button id="archiveSelected" class="btn btn-danger" disabled>
                                <i class="fas fa-archive"></i> Archive Selected
                            </button>
                        @endif
                        <p class="float-right">{{\App\Models\Test::NotArchived()->count()}} <a href="{{ route('admin.test.new.index', ['is_archived' => false]) }}">active</a>  test(s) (with {{ \App\Models\Test::archived()->count() }} <a href="{{ route('admin.test.new.index', ['is_archived' => true]) }}">archived</a>) </p>
                    </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <form action="{{route('admin.test.new.index')}}" method="GET" class="d-flex">
                                    <div class="input-group">
                                        <input type="text" 
                                               name="search" 
                                               class="form-control" 
                                               placeholder="Filter by subject, status, type..."
                                               value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            @if(request('search'))
                                                <a href="{{ route('admin.test.new.index') }}" class="btn btn-link" style="background: #fff; color: #6c757d; border: 1px solid #ced4da; border-left: none;">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            @endif
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search"></i> Search
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
                    
                    @if (!$tests->isEmpty())
                        <div>
                            <div class="font-weight-bold mb-2 ">
                                <div class="row mx-3 text-md">
                                    <div class="col-md-1">
                                        <span>
                                            <input type="checkbox" id="selectAll" />
                                        </span>
                                    </div>
                                    <div class="col-md-2">
                                        <span>Subjects</span>
                                    </div>
                                    <div class="col-md-1">
                                        <span>Status</span>
                                    </div>
                                    <div class="col-md-2">
                                        <span>Types</span>
                                    </div>
                                    <div class="col-md-1">
                                        <span>Questions</span>
                                    </div>
                                    <div class="col-md-1">
                                        <span>Duration (secs)</span>
                                    </div>
                                    <div class="col-md-2">
                                        <span># of Scores</span>
                                        <br/>
                                        <span>Last Taken</span>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <span>Average Score</span>
                                        <br/>
                                        <span>Low & High</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                @foreach ($tests as $test)
                                    <div class="card my-0 mx-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <span><input type="checkbox" class="test-checkbox" value="{{ $test->id }}" /></span>
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
                                                <div class="col-md-1 font-weight-bold">
                                                    <span>{{ $test->is_published ? 'Open' : 'Closed' }}</span>
                                                </div>

                                                <div class="col-md-2 font-weight-bold">
                                                    <span>{{ ucwords($test->testType->name) }}</span>
                                                </div>
                                                <div class="col-md-1 font-weight-bold">
                                                    <a
                                                        href="{{ route('admin.test.new.show', $test->id) }}">{{ $test->questions->count() }}</a>
                                                </div>
                                                <div class="col-md-1 font-weight-bold">
                                                    <span>{{ $test->duration }} sec</span>
                                                </div>
                                                <div class="col-md-2 font-weight-bold">
                                                    <span>{{ $test->testUsers->whereNotNull('end_time')->count() }}</span>
                                                    <br/>
                                                    <span class="text-muted" style="font-size: 0.85em;">{{ $test->last_taken ? \Carbon\Carbon::parse($test->last_taken)->diffForHumans() : 'Never' }}</span>
                                                </div>
                                                <div class="col-md-2 font-weight-bold">
                                                    <div class="progress" style="min-width: 100px;">
                                                        <div class="progress-bar {{ $test->average_score > 0 ? 'bg-warning' : 'bg-secondary' }}" 
                                                             role="progressbar" 
                                                             style="width: {{ max($test->average_score, 0) }}%; min-width: 40px; color: #000;" 
                                                             aria-valuenow="{{ max($test->average_score, 0) }}" 
                                                             aria-valuemin="0" 
                                                             aria-valuemax="100">
                                                            <span style="white-space: nowrap; font-size: 0.9em;">
                                                                {{ number_format($test->average_score, 1) }}%
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ number_format($test->lowest_score, 1) }}% - {{ number_format($test->highest_score, 1) }}%
                                                    </small>
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

        // Add this new script for the clear search functionality
        document.getElementById('clearSearch')?.addEventListener('click', function() {
            const url = new URL(window.location.href);
            url.searchParams.delete('search');
            window.location.href = url.toString();
        });

        // Multi-select functionality
        $(document).ready(function() {
            // Select all checkbox
            $('#selectAll').change(function() {
                $('.test-checkbox').prop('checked', $(this).prop('checked'));
                updateArchiveButtons();
            });

            // Individual checkboxes
            $('.test-checkbox').change(function() {
                updateArchiveButtons();
                // Update select all checkbox
                $('#selectAll').prop('checked', $('.test-checkbox:checked').length === $('.test-checkbox').length);
            });

            // Update archive button state
            function updateArchiveButtons() {
                const checkedCount = $('.test-checkbox:checked').length;
                $('#archiveSelected, #unarchiveSelected').prop('disabled', checkedCount === 0);
            }

            // Archive selected tests
            $('#archiveSelected').click(function() {
                const selectedIds = $('.test-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    if (confirm('Are you sure you want to archive the selected tests?')) {
                        $.ajax({
                            url: '{{ route("admin.test.new.archive") }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                test_ids: selectedIds
                            },
                            success: function(response) {
                                if (response.success) {
                                    location.reload();
                                } else {
                                    alert('Error archiving tests');
                                }
                            },
                            error: function() {
                                alert('Error archiving tests');
                            }
                        });
                    }
                }
            });

            // Unarchive selected tests
            $('#unarchiveSelected').click(function() {
                const selectedIds = $('.test-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    if (confirm('Are you sure you want to unarchive the selected tests?')) {
                        $.ajax({
                            url: '{{ route("admin.test.new.unarchive") }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                test_ids: selectedIds
                            },
                            success: function(response) {
                                if (response.success) {
                                    location.reload();
                                } else {
                                    alert('Error unarchiving tests');
                                }
                            },
                            error: function() {
                                alert('Error unarchiving tests');
                            }
                        });
                    }
                }
            });
        });
    </script>
</body>

</html>
