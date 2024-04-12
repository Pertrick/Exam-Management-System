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
                            <div class="row mx-auto w-50">
                                <div class="col-md-12">
                                    <form id="form-upload-id">
                                        <div class="form-group">
                                            <input type="file" id="file" class="form-control" required>
                                            <small>strictly adhere to sample file*</small>
                                        </div>
                                        <div class="form-group">
                                            <select name="subject" id="subject-id" class="form-control">
                                                <option value="" disabled selected>select subject</option>
                                                @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group text-center">
                                            <button type="button" class="btn btn-success"
                                                id="uploadBtn">Upload</button>
                                        </div>

                                    </form>

                                    <div>


                                        <div class="col-md-12 text-center">
                                            <a  class="btn btn-text " href="{{asset('assets/exam-ques.xlsx')}}" target="_blank">click to download sample excel</a>
                                        </div>

                                    </div>
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
        $("#uploadBtn").click(function(e) {
            e.preventDefault();

            const formData = new FormData();
            const fileInput = $("#file")[0];
            const selectedFile = fileInput.files[0];

            if (!selectedFile) {
                alert("Please select a file to upload");
                return;
            }

            formData.append("file", selectedFile);

            const subjectId = $("#subject-id").val();
            if (subjectId) {
                formData.append("subject_id", subjectId);
            }


            // Send the AJAX request
            $.ajax({
                url: "admin/question/upload",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function(xhr) {
                    $('#uploadBtn').text('Uploading...').attr('disabled', true);
                },
                success: function(response) {
                    console.log("Success:", response);
                },
                error: function(error) {
                    console.error("Error:", error);
                },
                complete: function(response) {
                    $('#uploadBtn').text('Upload').attr('disabled', false);
                }
            });
        });
    </script>
</body>

</html>
