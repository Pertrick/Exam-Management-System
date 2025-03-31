@include('admin.partials.header')
@push('styles')
<style>
.resource-section {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    margin-top: 10px;
}

.current-image, .current-pdf, .current-video {
    padding: 10px;
    background: #e9ecef;
    border-radius: 4px;
}

.custom-control {
    margin-bottom: 10px;
}

.card-footer {
    background-color: #f8f9fa;
}

.btn i {
    margin-right: 5px;
}
</style>
@endpush

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
                        <form action="{{ route('admin.resources.update', $resource->id) }}" method="POST"
                            id="form-subject" enctype="multipart/form-data">
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
                                                        <option value="" disabled>--choose subject--</option>
                                                        @foreach ($subjects as $subject)
                                                            <option value="{{ $subject->id }}"
                                                                {{ $subject->id == $resource->subject_id ? 'selected' : '' }}>
                                                                {{ $subject->name }}</option>
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
                                                        value="{{ old('name') ?? $resource->name }}">
                                                    @error('name')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea name="description" class="form-control">{{ old('description') ?? $resource->description }}</textarea>
                                                    @error('description')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- Cover Image -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Cover Image</label>
                                                    @if ($resource->cover_image)
                                                        <div class="current-image mb-2">
                                                            <img src="{{ Storage::url($resource->cover_image) }}"
                                                                alt="Current cover" class="img-thumbnail"
                                                                style="max-height: 100px;">
                                                        </div>
                                                    @endif
                                                    <input type="file" name="cover_image" class="form-control"
                                                        accept="image/png, image/jpeg, image/jpg">
                                                    <small class="text-muted">Upload new image to change or leave blank
                                                        to keep current</small>
                                                    @error('cover_image')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Resource Types -->
                                            <div class="row mt-4">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Resource Types</label>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="hasPdf" name="has_pdf"
                                                                {{ $resource->pdf_file ? 'checked' : '' }}
                                                                onchange="toggleResourceSection('pdf')">
                                                            <label class="custom-control-label" for="hasPdf">PDF
                                                                Document</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="hasVideo" name="has_video"
                                                                {{ $resource->uploaded_video ? 'checked' : '' }}
                                                                onchange="toggleResourceSection('video')">
                                                            <label class="custom-control-label" for="hasVideo">Video
                                                                Upload</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="hasEmbed" name="has_embed"
                                                                {{ $resource->video_url ? 'checked' : '' }}
                                                                onchange="toggleResourceSection('embed')">
                                                            <label class="custom-control-label" for="hasEmbed">External
                                                                Video URL</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- PDF Section -->
                                            <div id="pdf_section" class="col-md-12 resource-section"
                                                style="display: {{ $resource->pdf_file ? 'block' : 'none' }}">
                                                <div class="form-group">
                                                    <label>PDF Document</label>
                                                    @if ($resource->pdf_file)
                                                        <div class="current-pdf mb-2">
                                                            <i class="far fa-file-pdf"></i> Current:
                                                            {{ basename($resource->pdf_file) }}
                                                        </div>
                                                    @endif
                                                    <input type="file" name="pdf_file" class="form-control"
                                                        accept="application/pdf">
                                                    <small class="text-muted">Upload new PDF to change or leave blank
                                                        to keep current</small>
                                                    @error('pdf_file')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Video Upload Section -->
                                            <div id="video_section" class="col-md-12 resource-section"
                                                style="display: {{ $resource->uploaded_video ? 'block' : 'none' }}">
                                                <div class="form-group">
                                                    <label>Video File</label>
                                                    @if ($resource->uploaded_video)
                                                        <div class="current-video mb-2">
                                                            <i class="far fa-file-video"></i> Current:
                                                            {{ basename($resource->uploaded_video) }}
                                                        </div>
                                                    @endif
                                                    <input type="file" name="uploaded_video" class="form-control"
                                                        accept="video/mp4,video/mov,video/avi">
                                                    <small class="text-muted">Upload new video to change or leave blank
                                                        to keep current</small>
                                                    @error('uploaded_video')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div id="embed_section" class="col-md-12 resource-section"
                                                style="display: {{ $resource->video_url ? 'block' : 'none' }}">
                                                <div class="form-group">
                                                    <label>External Video URL</label>
                                                    <input type="url" name="video_url" class="form-control"
                                                        value="{{ old('video_url') ?? $resource->video_url }}"
                                                        placeholder="Enter YouTube, Vimeo or other video URL">
                                                    <small class="text-muted">Example:
                                                        https://www.youtube.com/watch?v=xxxxx</small>
                                                    @error('video_url')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <button type="submit" class="btn bg2 text-light"
                                            onclick="this.disabled= true; this.innerHTML='Updating...'; this.form.submit();">Update</button>
                                            <a href="{{ route('admin.resources.index') }}" class="btn btn-secondary">
                                                <i class="fa fa-times"></i> Cancel
                                            </a>
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
            function toggleResourceSection(type) {
                const section = document.getElementById(`${type}_section`);
                const checkbox = document.getElementById(`has${type.charAt(0).toUpperCase() + type.slice(1)}`);
                section.style.display = checkbox.checked ? 'block' : 'none';
            }

            // Initialize sections based on existing data
            document.addEventListener('DOMContentLoaded', function() {
                ['pdf', 'video', 'embed'].forEach(type => {
                    toggleResourceSection(type);
                });
            });
        </script>
</body>

</html>
