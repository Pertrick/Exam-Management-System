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
                        <form action="{{ route('admin.question.update', $question->id) }}" method="POST" id="form-subject" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-header">
                                            <span class="fa fa-book"> Edit Question</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Subject</label>
                                                    <select name="subject_id" id="" class="form-control">
                                                        <option value="{{ $question->subject_id }}" selected>
                                                            {{ $question->subject->name }}</option>
                                                    </select>

                                                    @error('subject_id')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Question Type</label>
                                                    <select name="type" id="" class="form-control"
                                                        value="{{ old('type') }}">
                                                        @foreach ($question_types as $type)
                                                            @if ($type == $question->type)
                                                                <option value="{{ $type }}" selected>
                                                                    {{ $type }}</option>
                                                            @else
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error('question_type')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Question</label>
                                                    <textarea name="question" id="question" class="form-control">
                                                        {{ $question->question}}
                                                    </textarea>
                                                    @if(!is_null($question->image))
                                                    <input type="file" name="question_image" id="question-image">
                                                    <img src="/storage/images/questions/{{$question->image->name}}" alt="{{$question->image->name}}" class="img-fluid mt-1" width="100" height="50" style="border:1px;">
                                                    @else
                                                    <input type="file"  name="question_image" id="question-image" class="">
                                                    @endif
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
                                                        value="{{ $question->point }}">
                                                    @error('point')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>


                                            @php $sn =1; @endphp
                                            @foreach ($question->options as $key => $option)
                                                @if($question->type =="option")

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Option {{ $sn++ }}</label>
                                                        <textarea name="option[]" id="option_1" class="form-control">{{ $option->label }}</textarea>
                                                        @error('option_1')
                                                            <div class="error text-danger text-xs">{{ $message }}
                                                            </div>
                                                        @enderror

                                                        @if(!is_null($option->image))
                                                        <input type="file" name="option_image[{{$key}}]" id="option-image" class="m-1">
                                                        <img src="/storage/images/options/{{$option->image->name}}" alt="{{$option->image->name}}" class="img-fluid mt-1" width="100" height="50" style="border:1px;">
                                                        @else
                                                        <input type="file"  name="option_image[{{$key}}]" id="option-image" class="m-1">
                                                        @endif
                                                        <input type="radio" name="is_correct"
                                                            id="is_correct" {{$option->is_correct ? 'checked': ''}}
                                                            value="{{$key}}"
                                                            class="form-control-sm float-right">
                                                    </div>
                                                </div>

                                                @elseif($question->type =="multiple-choice")
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Option {{ $sn++ }}</label>
                                                        <textarea name="option[]" id="option_1" class="form-control">{{ $option->label }}</textarea>
                                                        @error('option_1')
                                                            <div class="error text-danger text-xs">{{ $message }}
                                                            </div>
                                                        @enderror

                                                        @if(!is_null($option->image))
                                                        <input type="file" name="option_image[{{$key}}]" id="option-image" class="m-1">
                                                        <img src="/storage/images/options/{{$option->image->name}}" alt="{{$option->image->name}}" class="img-fluid mt-1" width="100" height="50" style="border:1px;">
                                                        @else
                                                        <input type="file"  name="option_image[{{$key}}]" id="option-image" class="m-1">
                                                        @endif
                                                        <input type="hidden" name="is_correct[{{ $key }}]"
                                                            id="is_correct" 
                                                            class="form-control-sm" value="off">
                                                        <input type="checkbox" name="is_correct[{{ $key }}]"
                                                            id="is_correct" {{ $option->is_correct ? 'checked': ''}}
                                                            class="form-control-sm float-right">
                                                    </div>
                                                </div>

                                                @elseif($question->type =="no-option" || $question->type == "no option")
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Answer</label>
                                                        <textarea name="option[]" id="option_1" class="form-control">{{ $option->label }}</textarea>
                                                        @error('option_1')
                                                            <div class="error text-danger text-xs">{{ $message }}
                                                            </div>
                                                        @enderror
                                                       
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach

                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn bg2 text-white">Save</button>
                                            <a href="{{url()->previous()}}" class="btn bg1 text-white" id="cancel">Cancel</a>
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
    </script>
</body>

</html>
