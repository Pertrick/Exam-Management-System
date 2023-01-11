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
                        <!-- form start -->
                        <form action="{{ route('admin.question.store') }}" method="POST" id="form-subject" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-header">
                                            <span class="fa fa-book"> Add Question</span>
                                        </div>
                                        <div class="row" id="row-id">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Subject</label>
                                                    <select name="subject_id" id="" class="form-control">
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

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Question</label>
                                                    <textarea name="question" id="question" class="form-control">{{ old('question') }}</textarea>
                                                    <input type="file" name="question_image" id="quest-image" class="m-1">
                                                    @error('question')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Question Point</label>
                                                    <input type="text" name="point" id="point"
                                                        class="form-control" placeholder="4"
                                                        value="{{ old('point') }}">
                                                    @error('point')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Question Type</label>
                                                    <select name="type" id="" class="question-type form-control"
                                                        value="{{ old('type') }}">
                                                        <option value="" selected disabled>--select question type
                                                            --</option>
                                                        @foreach ($question_types as $type)
                                                            <option value="{{ $type }}">{{ $type }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('type')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Option 1</label>
                                                    <textarea name="option[]" id="option_1" class="form-control">{{ old('option') }}</textarea>
                                                    <input type="file" name="option_image[0]" id="option-image-1" class="m-1">
                                                    @error('option_1')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                   
                                                    <input type="checkbox" name="is_correct[0]"
                                                        id="is_correct_1" class="form-control-sm float-right">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Option 2</label>
                                                    <textarea name="option[]" id="option_2" class="form-control">{{ old('option') }}</textarea>
                                                    <input type="file" name="option_image[1]" id="option_image_1" class="m-1">
                                                    @error('option')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                    <input type="checkbox" name="is_correct[1]" 
                                                        id="is_correct_2" class="form-control-sm float-right">
                                        
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>option 3</label>
                                                    <textarea name="option[]" id="option_3" class="form-control">{{ old('option') }}</textarea>
                                                    <input type="file" name="option_image[2]" id="option_image_2" class="m-1">
                                                    @error('option_3')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                    <input type="checkbox" name="is_correct[2]"
                                                        id="is_correct_3" class="form-control-sm float-right">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>option 4</label>
                                                    <textarea name="option[]" id="option_4" class="form-control">{{ old('option') }}</textarea>
                                                    <input type="file" name="option_image[3]" id="option_image_4" class="m-1">
                                                    @error('option')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                    <input type="checkbox" name="is_correct[3]" 
                                                        id="is_correct_4" class="form-control-sm float-right">

                                                </div>
                                            </div> --}}


                                        </div>
                                        <div class="col-md-12">
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
        $("select.question-type").change(function() {
            var question_type = $(this).children("option:selected").val();
            var count = 1;
            $('.option-added').remove();
           
            if(question_type == 'option'){
                $('.choice-added').remove();
                $('.no-option').remove();
               for(var i = 0;  i <4; i++){

                var option = ` 
                 <div class="col-md-6 option-added">
                        <div class="form-group">
                             <label>option ${count++}</label>
                                <textarea name="option[]" id="option_4" class="form-control">{{ old('option') }}</textarea>
                                    <input type="file" name="option_image[${i}]" id="option_image_${i}" class="m-1">
                                        @error('option')
                                            <div class="error text-danger text-xs">{{ $message }}</div>
                                         @enderror
                                        <input type="radio" name="is_correct" value="${i}" id="is_correct_${i}" class="form-control-sm float-right">
                        </div>

                  </div>`

                  $('#row-id').append(option);
               }
                
            }else if(question_type == 'multiple-choice'){
                $('.option-added').remove();
                $('.no-option').remove();
                for(var i = 0;  i <4; i++){

                    var option = ` 
                    <div class="col-md-6 choice-added">
                            <div class="form-group">
                                <label>option ${count++}</label>
                                    <textarea name="option[]" id="option_4" class="form-control">{{ old('option') }}</textarea>
                                        <input type="file" name="option_image[${i}]" id="option_image_${i}" class="m-1">
                                            @error('option')
                                                <div class="error text-danger text-xs">{{ $message }}</div>
                                            @enderror
                                            <input type="checkbox" name="is_correct[${i}]" 
                                                id="is_correct_${i}" class="form-control-sm float-right">
                            </div>

                    </div>`

                    $('#row-id').append(option);

            }
    
            }else if(question_type == 'no-option'){

                $('.choice-added').remove();
                $('.option-added').remove();
                var option = ` 
                <div class="col-md-12 no-option">
                        <div class="form-group">
                            <label>Answer</label>
                                <textarea name="option" id="option" placeholder=""type the answer" class="form-control">{{ old('answer') }}</textarea>
                                        @error('option')
                                            <div class="error text-danger text-xs">{{ $message }}</div>
                                        @enderror  
                        </div>                 
                </div>`

                $('#row-id').append(option);
            }
          
        });

        $(function() {
            $("#example1").DataTable();
        });

        $.get()
    </script>
</body>

</html>
