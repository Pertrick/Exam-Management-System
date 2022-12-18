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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-book"></span> Exam
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
                        <form action="{{ route('admin.test.update', $test->id) }}" method="POST" id="form-subject">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-header mb-3">
                                            <span class="fa fa-book"> Edit Exam</span>
                                        </div>
                                        <div class="row" id="row-id">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Subject</label>
                                                    <select name="subject_id" id="" class="form-control">
                                                        <option value="{{ $test->subject_id }}" selected disabled>
                                                            {{ $test->subject->name }}</option>
                                                    </select>

                                                    @error('subject_id')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Exam Duration</label>
                                                    <input type='text' placeholder="Enter exam duraton in seconds" value="{{$test->duration}}" class="form-control" name="duration">
                                                    @error('duration')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            @foreach($test->questions as $quest)

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="card-group"> 
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h4 class="card-title">{{$quest->question}}</h4>
                                                                @foreach($quest->options  as $option)
                                                                <p class="card-text">
                                                                    <li>{{$option->label}}</li>
                                                                </p>
                                                                @endforeach
                                                            </div>
                                                            <div class="card-footer"> 
                                                                <div class="text-left">
                                                                    <label class="text-right text-xs">*check to select question</label>
                                                                    <input type="checkbox" {{$quest->id ? 'checked' : ''}} name="question_ids[]" value="{{$quest->id}}" >
                                                                </div>
                                                                <div class="text-right">
                                                                    <small class="text-muted">Last updated:{{$option->updated_at}}</small> 
                                                                </div>
                                                            </div>
                                                        
                                                        </div>
                                                    </div>                             
                                                </div> 
                                            </div> 
                                            @endforeach         
                                            
                                            @foreach($questions as $new_quest)

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="card-group"> 
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h4 class="card-title">{{$new_quest->question}}</h4>
                                                                @foreach($new_quest->options  as $new_option)
                                                                <p class="card-text">
                                                                    <li>{{$new_option->label}}</li>
                                                                </p>
                                                                @endforeach
                                                            </div>
                                                            <div class="card-footer"> 
                                                                <div class="text-left">
                                                                    <label class="text-right text-xs">*check to select question</label>
                                                                    <input type="checkbox" name="question_ids[]" value="{{$new_quest->id}}" >
                                                                </div>
                                                                <div class="text-right">
                                                                    <small class="text-muted">Last updated:{{$new_option->updated_at}}</small> 
                                                                </div>
                                                            </div>
                                                        
                                                        </div>
                                                    </div>                             
                                                </div> 
                                            </div> 
                                            @endforeach        
                                        </div>                     
                                    </div>`


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

$("select.subject").change(function() {
            var subjectId = $(this).children("option:selected").val();
            var count = 1;
            $.get('/admin/exam/question/' + subjectId, (data) => {
                data.forEach(function(item, index) {
                    var card = `<div class="col-md-6 is-select">
                                    <div class="card-group"> 
                                        <div class="card">
                                            <div class="card-body"><h4 class="card-title"> ${count++}. ${item.question}</h4>`;
                    item.options.forEach(function(value, key) {
                        card += `<p class="card-text"><li>${value.label}</li></p>`
                    });
                    card +=`
                            </div>
                                    <div class="card-footer"> 
                                        <div class="text-left">
                                            <label class="text-right text-xs">*check to select question</label>
                                            <input type="checkbox" name="question_ids[]" value="${item.id}" >
                                        </div>
                                        <div class="text-right">
                                            <small class="text-muted">Last updated: ${item.updated_at}</small> 
                                        </div>
                                    </div>                                 
                                </div>                             
                            </div>                     
                        </div>`
                    $('#row-id').append(card);
                });

            });

            appendTime();
        });
        
        $('.is-select').on('click',function(){
            alert();
        });

        $(function() {
            $("#example1").DataTable();
        });

       


        function appendTime(){
            var time = `<div class="col-md-12">
                            <div class="form-group">
                                <label>Exam Duration</label>
                                    <input type='text' placeholder="Enter exam duraton in seconds" class="form-control" name="duration">
                                        @error('duration')
                                            <div class="error text-danger text-xs">{{ $message }}</div>
                                                @enderror
                                            </div>
                            </div>
                        </div>
                        `
                        $('#row-id').append(time);
                    
        }
    
    </script>
</body>

</html>
