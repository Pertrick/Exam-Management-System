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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-book"></span> Results
                            </h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Results</li>
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
                    <h4>Lookup Results Across Every Test</h4>
                        <p>
                            View and search test results across all your tests to see all the results for individual test, navigate
                            to its respective results page from the dashboard.
                        </p>
                    <!-- Search and Export Section -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <form action="{{ route('admin.result.index') }}" method="GET" class="d-flex">
                                <div class="input-group">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Filter by name..."
                                           value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <a href="{{ route('admin.result.index') }}" class="btn btn-link" style="background: #fff; color: #6c757d; border: 1px solid #ced4da; border-left: none;">
                                            <i class="fas fa-times"></i>
                                        </a>
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('admin.results.export', request()->query()) }}" 
                                           class="btn btn-success {{ $paginatedResults->isEmpty() ? 'disabled' : '' }}"
                                           {{ $paginatedResults->isEmpty() ? 'aria-disabled="true" tabindex="-1"' : '' }}>
                                            <i class="fas fa-file-export"></i> Export
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 d-flex justify-content-end align-items-center">
                            <div class="simple-pagination">
                                @if ($paginatedResults->onFirstPage())
                                    <span class="disabled"><i class="fas fa-chevron-left"></i></span>
                                @else
                                    <a href="{{ $paginatedResults->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a>
                                @endif
                                <input type="number" 
                                       id="pageInput" 
                                       value="{{ $paginatedResults->currentPage() }}" 
                                       min="1" 
                                       max="{{ $paginatedResults->lastPage() }}">
                                <span>of {{ $paginatedResults->lastPage() }}</span>
                                @if ($paginatedResults->hasMorePages())
                                    <a href="{{ $paginatedResults->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a>
                                @else
                                    <span class="disabled"><i class="fas fa-chevron-right"></i></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Student Name</th>
                                            <th>Email</th>
                                            <th>Score</th>
                                            <th>Started On</th>
                                            <th>Finished On</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($results as $subjectName => $subjectResults)
                                            <tr class="table-secondary">
                                                <td colspan="7"><strong>{{ $subjectName }}</strong></td>
                                            </tr>
                                            @forelse($subjectResults as $result)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><a href="{{route('admin.student.edit',$result->testUser->user->id)}}">{{ $result->testUser->user->name }}</a></td>
                                                    <td>{{ $result->testUser->user->email }}</td>
                                                    <td>
                                                        <div class="progress" style="min-width: 150px; max-width: 200px;">
                                                            <div class="progress-bar {{ $result->score_percentage > 0 ? 'bg-warning' : 'bg-secondary' }}" 
                                                                 role="progressbar" 
                                                                 style="width: {{ max($result->score_percentage, 0) }}%; min-width: 80px; color: #000;" 
                                                                 aria-valuenow="{{ max($result->score_percentage, 0) }}" 
                                                                 aria-valuemin="0" 
                                                                 aria-valuemax="100">
                                                                <span style="white-space: nowrap; font-size: 0.9em;">
                                                                    {{ number_format(max($result->score_percentage, 0), 2) }}% 
                                                                    ({{ $result->correct_answers ?? 0 }}/{{ $result->total_questions ?? 0 }})
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $result->testUser->start_time ? \Carbon\Carbon::parse($result->testUser->start_time)->format('M d, Y H:i') : 'N/A' }}</td>
                                                    <td>{{ $result->testUser->end_time ? \Carbon\Carbon::parse($result->testUser->end_time)->format('M d, Y H:i') : 'N/A' }}</td>
                                                    <td>
                                                        @if($result->testUser->start_time && $result->testUser->end_time)
                                                            <?php
                                                                $start = \Carbon\Carbon::parse($result->testUser->start_time);
                                                                $end = \Carbon\Carbon::parse($result->testUser->end_time);
                                                                $diff = $end->diff($start);
                                                                printf('%02d:%02d:%02d', $diff->h + $diff->d * 24, $diff->i, $diff->s);
                                                            ?>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">No results for this subject</td>
                                                </tr>
                                            @endforelse
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center"><i>No Exam taken yet!</i></td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- form start -->

            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
@include('admin.partials.footer')
<script>
    $(function() {
        $("#example1").DataTable();

    });

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

<style>
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
