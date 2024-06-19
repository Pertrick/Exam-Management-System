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
                        <form action="{{ route('admin.test.new.store') }}" method="POST" id="form-subject">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-header mb-3">
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

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select name="test_type" id="" class="form-control ">
                                                        <option value="" selected disabled>--select type --
                                                        </option>
                                                        @foreach ($testTypes as $type)
                                                            <option value="{{ $type->id }}">{{ $type->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    @error('test_type')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Exam Duration (seconds)</label>
                                                    <input type='text' placeholder="Enter exam duraton in seconds"
                                                        class="form-control" name="duration">
                                                    @error('duration')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Pass Mark (%)</label>
                                                    <input type='text' placeholder="Enter exam duraton in seconds"
                                                        class="form-control" name="pass_mark">
                                                    @error('pass_mark')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Exam Instruction</label>
                                                    <textarea id="" name="instruction" class="form-control" placeholder="enter exam instruction"></textarea>
                                                    @error('instruction')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Start Date</label>
                                                    <input type="datetime-local" name="start_date"
                                                        class="form-control" />
                                                    @error('start_date')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>End Date</label>
                                                    <input type="datetime-local" name="end_date" class="form-control" />
                                                    @error('end_date')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div>
                                                    <label>Exam Status</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="is_published" type="radio"
                                                        id="inlineCheckbox1" value="1" checked>
                                                    <label class="form-check-label" for="inlineCheckbox1">Open</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="is_published" type="radio"
                                                        id="inlineCheckbox2" value="0">
                                                    <label class="form-check-label" for="inlineCheckbox2">Closed</label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <button type="submit" class="btn bg2 text-white">Save</button>
                                            <a href="{{ url()->previous() }}" class="btn bg1 text-white"
                                                id="cancel">Cancel</a>
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
            var form = `<div class="col-md-12 mt-3">
                            <p class="font-weight-bold text-center">Select Questions</p>
                                <small class="font-weight-bold">select all* </small>
                              <input type="checkbox" name="select-all" onclick="check()" id="select-id"/>
                        </div>`;

            /* $.get('/admin/exam/question/' + subjectId, (data) => {
                 console.log(data);
                 $('#row-id').append(form);
                 data.forEach(function(item, index) {
                     var card =
                         `<div class="col-md-6 mb-2 is-select">
                                 <div class="card-group"> 
                                     <div class="card">
                                         <div class="card-body"><h4 class="card-title"> ${item.question} `
                     if (item.image != null) {
                         console.log(item.image);
                         card +=
                             `<img src="/storage/images/questions/${item.image.name}" class="border" alt="${item.image.name}" width="100" height="50"> `
                     }

                     card += `</h4>`;
                     item.options.forEach(function(value, key) {
                         if (value.image == null) {
                             card += `<p class="card-text"><li>${value.label}</li></p>`
                         } else {
                             card +=
                                 `<p class="card-text"><li>${(value.label) ?? ''}<img src="/storage/images/options/${value.image.name}" alt="${value.image.name}" width="100" height="50"></li></p>`
                         }

                     });
                     card += `
                         </div>
                                 <div class="card-footer"> 
                                     <div class="text-left">
                                         <label class="text-right text-xs">*check to select question</label>
                                         <input type="checkbox" name="question_ids[]" value="${item.id}" class="option-check">
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




             });*/

            appendTime();
            passMark();

            areAllChecked();

            function areAllChecked() {
                let allChecked = $('.option-check').filter(':not(:checked)').length === 0;
                if (allChecked) {
                    $("#select-id").prop('checked', true);
                } else {
                    $("#select-id").prop('checked', false);
                }
            }
        });

        $(function() {
            $("#example1").DataTable();
        });


        // function appendTime() {
        //     var time = `<div class="col-md-12">
    //                     <div class="form-group">
    //                         <label>Exam Duration</label>
    //                             <input type='text' placeholder="Enter exam duraton in seconds" class="form-control" name="duration">
    //                                 @error('duration')
    //                                     <div class="error text-danger text-xs">{{ $message }}</div>
    //                                         @enderror
    //                                     </div>
    //                     </div>
    //                 </div>
    //                 `
        //     $('#row-id').append(time);

        // }

        // function passMark() {
        //     var pass_mark = `<div class="col-md-12">
    //                     <div class="form-group">
    //                         <label>Pass Mark</label>
    //                             <input type='text' placeholder="Enter Pass Mark" class="form-control" name="pass_mark">
    //                                 @error('pass_mark')
    //                                     <div class="error text-danger text-xs">{{ $message }}</div>
    //                                         @enderror
    //                                     </div>
    //                     </div>
    //                 </div>
    //                 `
        //     $('#row-id').append(pass_mark);

        // }



        function check() {
            var checkBox = document.getElementById("select-id");
            if (checkBox.checked) {
                $('.option-check').prop('checked', true);
            } else {
                $('.option-check').prop('checked', false);
            }
        }

        $('.option-check').on('click', function(e) {
            areAllChecked();
        });
    </script>
</body>

</html>
