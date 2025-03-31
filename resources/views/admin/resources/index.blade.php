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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-book"></span> Resources
                            </h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                            <div class="">
                                <a class="btn btn-sm btn-success" href="{{ route('admin.resources.create') }}">
                                    <i class="fa fa-plus"></i> Add Resource
                                </a>
                            </div>

                            <br><br>
                            <div class="col-md-12 table-responsive">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Subject</th>
                                            <th>cover image</th>
                                            {{-- <th>Resource</th> --}}
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($resources as $resource)
                                            <tr>
                                                <td>{{ $resource->name }}</td>
                                                <td>
                                                    {{ $resource->description }}

                                                </td>
                                                <td>{{ $resource->subject->name }}</td>
                                                <td><img width="100" height="70"
                                                        src="{{ $resource->cover_image ? asset('storage' . $resource->cover_image) : asset('resources-assets/default-book.png') }}" />
                                                </td>

                                                {{-- <td>
                                                    <img width="100" height="70"
                                                        src="{{ asset('resources-assets/pdf-img.png') }}" />
                                                </td> --}}
                                                <td class="text-right">

                                                    <a class="btn btn-sm btn-info"
                                                        href="{{ route('admin.resources.show', $resource->uuid) }}"
                                                        title="view resource"><i class="fa fa-eye"></i>
                                                    </a>

                                                    <a class="btn btn-sm bg3 text-white"
                                                        href="{{ route('admin.resources.edit', $resource->id) }}"
                                                        title="edit"><i class="fa fa-edit text-white"></i>
                                                    </a>

                                                    <form action="{{ route('admin.resources.delete', $resource->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-sm bg1 text-white" type="submit"
                                                            onclick="return confirm('Are you sure?')" title="delete"><i
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
    <div id="delete" class="modal animated rubberBand delete-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="EMS/asset/img/sent.png" alt="" width="50" height="46">
                    <h3>Are you sure want to delete this Subject?</h3>
                    <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn bg1">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    @include('admin.partials.footer')
    <script>
        $(function() {
            $("#example1").DataTable();
        });

        resetForm();
        editSubject(resource);

        function resetForm() {
            $('#cancel').on('click', (e) => {
                e.preventDefault();
                $('#subject').val('');
                $('#name').val('');
                $('#link').val('');
            });
        }

        function editResource(resource) {
            $('#subject').val(resource.subject_id).prop({
                "selected": true
            });
            $('#subject').find('option').not(':selected').remove();
            $('#name').val(resource.name);
            $('#link').val(resource.link);

        }
    </script>
</body>

</html>
