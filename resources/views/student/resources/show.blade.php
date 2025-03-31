@include('student.partials.header')

<style>
    .pdf-viewer {
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
    }

    .pdf-toolbar {
        margin-bottom: 7px;
    }

    #pdf-canvas {
        margin: 20px auto;
    }


    @media (max-width: 768px) {
        .pdf-toolbar {
            flex-direction: column;
        }

        .pdf-toolbar .input-group {
            margin-top: 0.5rem;
        }
    }
</style>

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
                                <li class="breadcrumb-item active"><a href="{{ route('student.resources.index') }}">Resources</li>
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
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @if (isset($resourceData['pdf_url']))
                                        <a class="nav-item nav-link active" id="nav-pdf-tab" data-toggle="tab"
                                            href="#nav-pdf" role="tab" aria-controls="nav-pdf"
                                            aria-selected="true">PDF Document</a>
                                    @endif

                                    @if (isset($resourceData['video_url']))
                                        <a class="nav-item nav-link" id="nav-video-tab" data-toggle="tab"
                                            href="#nav-video" role="tab" aria-controls="nav-video"
                                            aria-selected="false">Video</a>
                                    @endif

                                    @if (isset($resourceData['embed_url']))
                                        <a class="nav-item nav-link" id="nav-embed-tab" data-toggle="tab"
                                            href="#nav-embed" role="tab" aria-controls="nav-embed"
                                            aria-selected="false">External Video</a>
                                    @endif

                                    <a class="nav-item nav-link" id="nav-info-tab" data-toggle="tab" href="#nav-info"
                                        role="tab" aria-controls="nav-info" aria-selected="false">Resource Info</a>
                                </div>
                            </nav>

                            <div class="tab-content" id="nav-tabContent">
                                @if (isset($resourceData['pdf_url']))
                                    <div class="tab-pane fade show active" id="nav-pdf" role="tabpanel"
                                        aria-labelledby="nav-pdf-tab">
                                        <div class="container m-2" style="background-color: #dbe1f1">
                                            <h4 class="text-dark p-3">{{ $resource->name }}</h4>
                                            <div id="pdf-viewer" class="pdf-viewer">
                                                <div id="pdf-header" class="pdf-header mb-3 text-dark">
                                                    Page <span id="page-num-display">1</span> of <span
                                                        id="total-pages">1</span>
                                                </div>
                                                <div id="pdf-canvas"></div>

                                                <div class="pdf-toolbar">
                                                    <div class="input-group mb-3 ">
                                                        <div class="mx-auto w-50">
                                                            <input type="number" id="page-num" class=""
                                                                min="1" value="1">
                                                            <button id="go-to-page" class="btn btn-success">Go</button>
                                                        </div>

                                                    </div>
                                                    <div class="btn-group mt-3" role="group">
                                                        <button id="first-page" class="btn btn-secondary">First
                                                            Page</button>
                                                        <button id="prev-page"
                                                            class="btn btn-primary mx-1">Previous</button>
                                                        <button id="next-page" class="btn btn-info mr-1">Next</button>
                                                        <button id="last-page" class="btn btn-secondary">Last
                                                            Page</button>

                                                    </div>

                                                    <div class="input-group mt-3 mx-auto w-25 text-light">
                                                        <label for="scale">scale: </label>
                                                        <input type="number" id="scale" min="0.1"
                                                            max="1.6" step="0.1" value="1">
                                                        <button id="apply-scale"
                                                            class="btn btn-sm btn-primary mx-1">Apply</button>
                                                    </div>
                                                </div>

                                                <div id="pdf-canvas" class="pdf-canvas">
                                                    <div id="loading-indicator" class="text-center">
                                                        <div class="spinner-border text-primary" role="status">
                                                            <span class="visually-hidden"></span>
                                                        </div>
                                                        <p>Loading PDF...</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($resourceData['video_url']))
                                    <div class="tab-pane fade" id="nav-video" role="tabpanel"
                                        aria-labelledby="nav-video-tab">
                                        <div class="container m-2">
                                            <div class="video-container">
                                                <video controls width="100%" class="mt-3">
                                                    <source src="{{ $resourceData['video_url'] }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($resourceData['embed_url']))
                                    <div class="tab-pane fade" id="nav-embed" role="tabpanel"
                                        aria-labelledby="nav-embed-tab">
                                        <div class="container m-2">
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <iframe class="embed-responsive-item"
                                                    src="{{ $resourceData['embed_url'] }}" allowfullscreen></iframe>
                                            </div>
                                            <div>
                                                <a target="_blank" href="{{$resourceData['external_video_url']}}">Link</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="tab-pane fade" id="nav-info" role="tabpanel"
                                    aria-labelledby="nav-info-tab">
                                    <div class="container m-2">
                                        <h6>{{ $resource->name }}</h6>
                                        <p>{{ $resource->description }}</p>
                                        <div class="resource-metadata">
                                            <p><strong>Subject:</strong> {{ $resource->subject->name }}</p>
                                            <p><strong>Added:</strong> {{ $resource->created_at->format('M d, Y') }}</p>
                                            @if ($resource->updated_at != $resource->created_at)
                                                <p><strong>Last Updated:</strong>
                                                    {{ $resource->updated_at->format('M d, Y') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

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


        document.addEventListener('DOMContentLoaded', function() {
            const pdfPath = "{{ asset($resourceData['pdf_url']) }}";
            const pdfViewer = document.getElementById('pdf-viewer');
            const pdfCanvas = document.getElementById('pdf-canvas');
            pdfCanvas.addEventListener('contextmenu', function(event) {
                event.preventDefault(); // Prevent the default context menu
            });
            const pdfHeader = document.getElementById('pdf-header');
            const pageNumDisplay = document.getElementById('page-num-display');
            const totalPageDisplay = document.getElementById('total-pages');
            const loadingIndicator = document.getElementById('loading-indicator');
            const pageInput = document.getElementById('page-num');
            let currentPage = 1;
            let pdfInstance = null;
            let pdfScale = 1.0;

            const renderPage = (num, scale) => {
                pdfInstance.getPage(num).then((page) => {
                    pdfScale = scale; // Update global scale variable
                    const viewport = page.getViewport({
                        scale
                    });

                    pdfCanvas.innerHTML = ''; // Clear previous canvas
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    pdfCanvas.appendChild(canvas);

                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };

                    // Use page rendering promise to ensure the first page is rendered before checking the rendering progress of the next page
                    const renderTask = page.render(renderContext);
                    renderTask.promise.then(() => {
                        loadingIndicator.style.display =
                            'none'; // Hide loading spinner after rendering
                    }).catch((error) => {
                        console.error('Error rendering page:', error);
                    });

                    // Update page number display
                    pageNumDisplay.textContent = num;
                    totalPageDisplay.textContent = pdfInstance.numPages;
                    pageInput.value = num; // Update page input field

                    // Update button states based on current page
                    updateButtonStates(num);
                }).catch((error) => {
                    console.error('Error fetching page:', error);
                });
            };

            // Function to fetch number of pages and initialize PDF
            const initializePdf = () => {
                pdfjsLib.getDocument(pdfPath).promise.then((pdf) => {
                    pdfInstance = pdf;
                    renderPage(currentPage, pdfScale);
                }).catch((error) => {
                    console.error('Error loading PDF:', error);
                });
            };

            initializePdf();

            // Button events
            document.getElementById('prev-page').addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderPage(currentPage, pdfScale);
                }
            });

            document.getElementById('next-page').addEventListener('click', () => {
                if (currentPage < pdfInstance.numPages) {
                    currentPage++;
                    renderPage(currentPage, pdfScale);
                }
            });

            document.getElementById('go-to-page').addEventListener('click', () => {
                const pageNum = parseInt(pageInput.value);
                if (pageNum > 0 && pageNum <= pdfInstance.numPages) {
                    currentPage = pageNum;
                    renderPage(currentPage, pdfScale);
                } else {
                    alert(`Please enter a valid page number between 1 and ${pdfInstance.numPages}`);
                }
            });

            document.getElementById('apply-scale').addEventListener('click', () => {
                const scale = parseFloat(document.getElementById('scale').value);
                if (scale >= 0.1 && scale <= 1.8) {
                    pdfScale = scale;
                    renderPage(currentPage, pdfScale);
                } else {
                    alert('Please enter a scale value between 0.1 and 1.8');
                }
            });


            document.getElementById('first-page').addEventListener('click', () => {
                currentPage = 1;
                renderPage(currentPage, pdfScale);
            });

            document.getElementById('last-page').addEventListener('click', () => {
                currentPage = pdfInstance.numPages;
                renderPage(currentPage, pdfScale);
            });


            const updateButtonStates = (pageNum) => {
                const prevButton = document.getElementById('prev-page');
                const nextButton = document.getElementById('next-page');

                prevButton.disabled = pageNum <= 1;
                nextButton.disabled = pageNum >= pdfInstance.numPages;

                // Highlight current page in navigation
                const pageButtons = document.querySelectorAll('.page-nav-button');
                pageButtons.forEach((button) => {
                    if (parseInt(button.dataset.pageNum) === pageNum) {
                        button.classList.add('active');
                    } else {
                        button.classList.remove('active');
                    }
                });
            };


            document.addEventListener('keydown', (event) => {
                switch (event.key) {
                    case 'ArrowLeft':
                        if (currentPage > 1) {
                            currentPage--;
                            renderPage(currentPage, pdfScale);
                        }
                        break;
                    case 'ArrowRight':
                        if (currentPage < pdfInstance.numPages) {
                            currentPage++;
                            renderPage(currentPage, pdfScale);
                        }
                        break;
                    case 'Enter':
                        const pageNum = parseInt(pageInput.value);
                        if (pageNum > 0 && pageNum <= pdfInstance.numPages) {
                            currentPage = pageNum;
                            renderPage(currentPage, pdfScale);
                        } else {
                            alert(`Please enter a valid page number between 1 and ${pdfInstance.numPages}`);
                        }
                        break;
                    default:
                        break;
                }
            });



            const handleError = (message) => {
                console.error(message);
                loadingIndicator.innerHTML = `<p>${message}</p>`;
            };

            // // Inside renderPage function
            // .catch((error) => {
            //     handleError(`Error rendering page ${num}: ${error.message}`);
            // });

            // // Inside initializePdf function
            // .catch((error) => {
            //     handleError(`Error loading PDF: ${error.message}`);
            // });


        });
    </script>
</body>

</html>
