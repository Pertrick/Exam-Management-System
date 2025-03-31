@include('student.partials.header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!--Nav bar -->
        @include('student.partials.navigation')
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
                                Resources</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">Resources</li>
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
                            <div class="col-md-12 table-responsive">
                                <section class="food_section layout_padding-bottom">
                                    <div class="container">
                                        <div class="heading_container heading_center">
                                            <h2>
                                                Top Courses That are open for Students
                                            </h2>
                                        </div>

                                        <form action="{{route('student.resources.index')}}" method="get" class="mt-2 mx-2">
                                            <div class="input-group">
                                                <input type="search"
                                                    placeholder="search courses by name or description" name="search"
                                                    id="resourceId" class="form-control mx-1"/>
                                                <input type="submit" class="btn btn-success" value="search" />
                                            </div>
                                        </form>

                                        <div class="text-center">
                                            @if(request()->has('search'))
                                                <a href="{{route('student.resources.index')}}" class="btn btn-link text-sm">cancel search</a>
                                            @endif
                                        </div>

                                        <div class="filters-content mt-2">
                                            <div class="row grid">
                                                @forelse($resources as $resource)
                                                    <div class="col-sm-6 col-lg-4 all pizza">
                                                        <div class="box">
                                                            <div>
                                                                <a
                                                                    href="{{ route('student.resources.show', $resource->uuid) }}">
                                                                    <div class="img-box">
                                                                        <img src="{{ !$resource->cover_image ? asset('resources-assets/default-book.png') : asset("storage$resource->cover_image") }}"
                                                                            alt="{{ $resource->name }}">
                                                                    </div>
                                                                </a>
                                                                <div class="detail-box">
                                                                    <h5>
                                                                        <a href="{{ route('student.resources.show', $resource->uuid) }}"
                                                                            class="text-light">
                                                                            {{ $resource->name }}
                                                                        </a>
                                                                    </h5>
                                                                    <p class="text-xs">
                                                                        {{ $resource->description }}
                                                                    </p>
                                                                    {{--                                                   <div class="options"> --}}
                                                                    {{--                                                       <h6> --}}
                                                                    {{--                                                           $20 --}}
                                                                    {{--                                                       </h6> --}}
                                                                    {{--                                                       <a href=""> --}}
                                                                    {{--                     --}}
                                                                    {{--                                                       </a> --}}
                                                                    {{--                                                   </div> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <p>No resource to Show</p>
                                                @endforelse

                                            </div>
                                        </div>

                                        <nav aria-label="Page navigation">
                                            <ul class="pagination justify-content-center mt-4">
                                                @if ($resources->onFirstPage())
                                                    <li class="page-item disabled">
                                                        <span class="page-link">&laquo; Previous</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $resources->previousPageUrl() }}"
                                                            rel="prev">&laquo; Previous</a>
                                                    </li>
                                                @endif

                                                @if ($resources->hasMorePages())
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $resources->nextPageUrl() }}"
                                                            rel="next">Next &raquo;</a>
                                                    </li>
                                                @else
                                                    <li class="page-item disabled">
                                                        <span class="page-link">Next &raquo;</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </nav>
                                    </div>
                                </section>
                                <!-- end food section -->
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
        $(function() {
            $("#example1").DataTable();
        });
    </script>
</body>

</html>
