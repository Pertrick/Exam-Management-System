@include('admin.partials.header')
<style>
    .dropzone {
        border: 2px dashed #0087F7;
        border-radius: 5px;
        background: white;
        min-height: 150px;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .dropzone .dz-message {
        font-weight: 400;
        text-align: center;
        margin: 2em 0;
    }

    .dropzone .dz-preview {
        margin: 10px;
    }

    .dropzone .dz-preview .dz-image {
        border-radius: 5px;
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
                        <div class="mt-3 mx-3 text-right">
                            <a class="btn btn-sm btn-success" href="{{ route('admin.resources.index') }}">
                                <i class="fa fa-eye"></i> View Resources
                            </a>
                        </div>
                        <!-- form start -->
                        <form action="{{ route('admin.resources.store') }}" method="POST" id="form-subject"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-header">
                                            <span class="fa fa-book">Add Resources</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mt-2">
                                                <div class="form-group">
                                                    <label>Subject </label>
                                                    <select name="subject_id" id="subject" class="form-control">
                                                        <option value="" selected disabled>--choose subject--
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
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control" placeholder="" value="{{ old('name') }}">
                                                    @error('name')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                                                    @error('description')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Upload Cover Image</label>
                                                    <input type="file" name="cover_image" class="form-control"
                                                        accept="image/png, image/jpeg, image/jpg,">
                                                    @error('cover_image')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>



                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Resource Types (Select all that apply)</label>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="hasPdf" name="has_pdf"
                                                            onchange="toggleResourceSection('pdf')">
                                                        <label class="custom-control-label" for="hasPdf">PDF
                                                            Document</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="hasVideo" name="has_video"
                                                            onchange="toggleResourceSection('video')">
                                                        <label class="custom-control-label" for="hasVideo">Video
                                                            Upload</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="hasEmbed" name="has_embed"
                                                            onchange="toggleResourceSection('embed')">
                                                        <label class="custom-control-label" for="hasEmbed">External
                                                            Video URL</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Replace the PDF Section with this -->
                                            <div id="pdf_section" class="resource-section" style="display: none;">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>PDF Document</label>
                                                        <input type="file" name="pdf_file" class="form-control"
                                                            accept="application/pdf">
                                                        <small class="text-muted">Maximum file size: 10MB</small>
                                                        @error('pdf_file')
                                                            <div class="error text-danger text-xs">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Replace the Video Upload Section with this -->
                                            <div id="video_section" class="resource-section" style="display: none;">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Upload Video</label>
                                                        <input type="file" name="uploaded_video"
                                                            class="form-control"
                                                            accept="video/mp4,video/mov,video/avi">
                                                        <small class="text-muted">Maximum file size: 50MB</small>
                                                        @error('uploaded_video')
                                                            <div class="error text-danger text-xs">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- External Video URL Section -->
                                            <div id="embed_section" class="resource-section" style="display: none;">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>External Video URL</label>
                                                        <input type="url" name="video_url" class="form-control"
                                                            placeholder="Enter YouTube, Vimeo or other video URL">
                                                        <small class="text-muted">Example:
                                                            https://www.youtube.com/watch?v=xxxxx</small>
                                                        @error('video_url')
                                                            <div class="error text-danger text-xs">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn bg2 text-light"
                                                onclick="this.disabled= true; this.innerHTML='Uploading...'; this.form.submit();">Upload</button>
                                            <button class="btn bg1 text-light" id="cancel">Cancel</button>
                                        </div>
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
        Dropzone.autoDiscover = false;

        function toggleResourceSection(type) {
            const section = document.getElementById(`${type}_section`);
            const checkbox = document.getElementById(`has${type.charAt(0).toUpperCase() + type.slice(1)}`);
            section.style.display = checkbox.checked ? 'block' : 'none';

            // Initialize dropzone when section is shown
            if (checkbox.checked) {
                switch (type) {
                    case 'pdf':
                        initializePdfDropzone();
                        break;
                    case 'video':
                        initializeVideoDropzone();
                        break;
                }
            }
        }


        // Form validation
        document.getElementById('form-subject').addEventListener('submit', function(e) {
            e.preventDefault();

            const hasPdf = document.getElementById('hasPdf').checked;
            const hasVideo = document.getElementById('hasVideo').checked;
            const hasEmbed = document.getElementById('hasEmbed').checked;

            // Check if at least one type is selected
            if (!hasPdf && !hasVideo && !hasEmbed) {
                alert('Please select at least one resource type');
                return;
            }

            // Validate selected types
            let isValid = true;

            if (hasPdf && !document.getElementById('pdf_file').value) {
                alert('Please upload a PDF document');
                isValid = false;
            }

            if (hasVideo && !document.getElementById('uploaded_video').value) {
                alert('Please upload a video');
                isValid = false;
            }

            if (hasEmbed && !document.querySelector('input[name="video_url"]').value) {
                alert('Please enter a video URL');
                isValid = false;
            }

            if (isValid) {
                this.submit();
            }
        });
    </script>
</body>

</html>
