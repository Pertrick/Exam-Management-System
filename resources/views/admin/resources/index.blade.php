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
                        <!-- form start -->
                        <form action="{{ route('admin.resources.store') }}" method="POST" id="form-subject">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card-header">
                                            <span class="fa fa-book"> Subject </span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mt-2">
                                                <div class="form-group">
                                                    <label>Subject </label>
                                                    <select name="subject_id" id="subject">
                                                        <option value="" selected disabled>--choose subject--</option>
                                                        @foreach($subjects as $subject) 
                                                            <option value="{{$subject->id}}">{{$subject->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('subject_id')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control" placeholder=""
                                                        value="{{old('name')}}">
                                                    @error('name')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Link</label>
                                                    <textarea name="link" id="link" class="form-control">{{ old('link') }}</textarea>
                                                    @error('link')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn bg2">Save</button>
                                            <button class="btn bg1" id="cancel">Cancel</button>
                                        </div>
                        </form>
                    </div>

                    <div class="col-md-9 table-responsive" style="border-left: 1px solid #ddd;">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Link</th>
                                    <th>Subject</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resources as $resource)
                                    <tr data-toggle="modal" data-id="{{$resource}}" data-target="#delete">
                                        <td>{{ $resource->name }}</td>
                                        <td>{{ $resource->link}}</td>
                                        <td>{{ $resource->subject->name }}</td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-sm btn-info"
                                                onclick="editResource({{ $resource }})"><i
                                                    class="fa fa-edit"></i></button>

                                            <form action="{{ route('admin.subject.delete', $resource->id) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm bg1 text-white" type="submit"
                                                    onclick="return confirm('Are you sure?')" >delete<i class="fa fa-trash-alt text-white"></i></button>
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
    {{-- <div id="delete" class="modal animated rubberBand delete-modal" role="dialog">
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
    </div> --}}
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
            $('#subject').val(resource.subject_id).prop({"selected":true});
            $('#subject').find('option').not(':selected').remove();
            $('#name').val(resource.name);
            $('#link').val(resource.link);

        }
    </script>
</body>

</html>
