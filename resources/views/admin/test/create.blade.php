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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-book"></span> Subject
                            </h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.question.index') }}">Home</a></li>
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
                        <!-- form start -->
                        <form action="{{ route('admin.question.store') }}" method="POST" id="form-subject">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-header">
                                            <span class="fa fa-book"> Add Exam</span>
                                        </div>
                                        <div class="row" id="row-id">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Subject</label>
                                                    <select name="subject_id" id=""
                                                        class="form-control subject">
                                                        <option value="" selected disabled>--select subject --
                                                        </option>
                                                        @foreach ($subjects as $subject)
                                                            <option value="{{ $subject->id }}">{{ $subject->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    @error('subject_id')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>


                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <button type="submit" class="btn bg2">Save</button>
                                            <button class="btn bg1" id="cancel">Cancel</button>
                                        </div>
                        </form>
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

    <!-- jQuery -->
    @include('admin.partials.footer')
    <script>
        $(function() {
            $("#example1").DataTable();
        });

        $("select.subject").change(function() {
            var subjectId = $(this).children("option:selected").val();
            $.get('/admin/exam/question/' + subjectId, (data) => {
                data.forEach(function(item, index) {
                    var card = `<div class="col-md-6">
                                    <div class="card-group"> 
                                        <div class="card">
                                            <div class="card-body is-selected"><h4 class="card-title">${item.question}</h4>`;
                    item.options.forEach(function(value, key) {
                        card += `<p class="card-text">${value.label}</p>`
                    });
                    card +=`
                            </div>
                                    <div class="card-footer"> 
                                        <small class="text-muted">Last updated 3 mins ago</small> 
                                    </div>                                 
                                </div>                             
                            </div>                         
                        </div>`
                    $('#row-id').append(card);
                });

            });
        });


        $('div.is-selected').on('click','.card[data-clickable=true]',function(){
            console.log('jfjfkjd');
        });
    </script>
</body>

</html>
