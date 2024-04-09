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
                                                    <label>Type</label>
                                                    <select name="test_type_id" id="" class="form-control">
                                                        <option value="" disabled> --select type --</option>
                                                        @foreach ($testTypes as $type)
                                                            <option value="{{ $type->id }}"
                                                                {{ $test->testType->id == $type->id ? 'selected' : '' }}>
                                                                {{ $type->name }}</option>
                                                        @endforeach

                                                    </select>

                                                    @error('subject_id')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Exam Duration</label>
                                                    <input type='text' placeholder="Enter exam duraton in seconds"
                                                        value="{{ $test->duration }}" class="form-control"
                                                        name="duration">
                                                    @error('duration')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Pass Mark</label>
                                                    <input type='text' placeholder="Enter exam duraton in seconds"
                                                        value="{{ $test->pass_mark }}" class="form-control"
                                                        name="pass_mark">
                                                    @error('pass_mark')
                                                        <div class="error text-danger text-xs">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <p class="font-weight-bold text-center">Select Questions</p>
                                                <small class="font-weight-bold">select all* </small>
                                                <input type="checkbox" name="select-all" onclick="check()"
                                                    id="select-id" />
                                            </div>

                                            @foreach ($test->questions as $quest)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="card-group">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">
                                                                        {{ $quest->question }}
                                                                        @if ($quest->image)
                                                                            <img src="/storage/images/questions/{{ $quest->image->name }}"
                                                                                class="border"
                                                                                alt="{{ $quest->image->name }}"
                                                                                width="100" height="50">
                                                                        @endif
                                                                    </h4>
                                                                    @foreach ($quest->options as $option)
                                                                        <p class="card-text">
                                                                            <li>
                                                                                {{ $option->label }}
                                                                                @if ($option->image)
                                                                                    <img src="/storage/images/options/{{ $option->image->name }}"
                                                                                        class="border"
                                                                                        alt="{{ $option->image->name }}"
                                                                                        width="100" height="50">
                                                                                @endif
                                                                            </li>
                                                                        </p>
                                                                    @endforeach
                                                                </div>
                                                                <div class="card-footer">
                                                                    <div class="text-left">
                                                                        <label class="text-right text-xs">*check to
                                                                            select question</label>
                                                                        <input type="checkbox"
                                                                            {{ $quest->id ? 'checked' : '' }}
                                                                            name="question_ids[]"
                                                                            value="{{ $quest->id }}"
                                                                            class="option-check">
                                                                    </div>
                                                                    <div class="text-right">
                                                                        <small class="text-muted">Last
                                                                            updated:{{ $quest->updated_at }}</small>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            @foreach ($questions as $new_quest)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="card-group">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">{{ $new_quest->question }}
                                                                    </h4>
                                                                    @foreach ($new_quest->options as $new_option)
                                                                        <p class="card-text">
                                                                            <li>{{ $new_option->label }}</li>
                                                                        </p>
                                                                    @endforeach
                                                                </div>
                                                                <div class="card-footer">
                                                                    <div class="text-left">
                                                                        <label class="text-right text-xs">*check to
                                                                            select question</label>
                                                                        <input type="checkbox" name="question_ids[]"
                                                                            value="{{ $new_quest->id }}"
                                                                            class="option-check">
                                                                    </div>
                                                                    <div class="text-right">
                                                                        <small class="text-muted">Last
                                                                            updated:{{ $new_option->updated_at }}</small>
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
        areAllChecked();

        function areAllChecked() {
            let allChecked = $('.option-check').filter(':not(:checked)').length === 0;
            if (allChecked) {
                $("#select-id").prop('checked', true);
            } else {
                $("#select-id").prop('checked', false);
            }
        }

        function check() {
            var checkBox = document.getElementById("select-id");
            if (checkBox.checked) {
                $('.option-check').prop('checked', true);
            } else {
                $('.option-check').prop('checked', false);
            }
        }


        $('.option-check').on('click', function(e) {
            console.log(e);
            areAllChecked();
        });


    </script>
</body>

</html>
