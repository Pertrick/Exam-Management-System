<style>
    textarea:focus,
    input:focus {
        outline: none;
    }
</style>
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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-file-word"></span>
                                {{ $test->subject->name }}
                            </h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">{{ $test->subject->name }}</li>
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
                        <form action="{{ route('admin.question.store') }}" method="POST" id="">
                            @csrf
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="card-group">
                                            <div class="card main-card">
                                                <div class="text-center mt-2">
                                                    <p class="font-weight-bold">
                                                        {{ $test->subject->name }}
                                                        ({{ $test->testType->name }})
                                                        <input type="hidden" id="testId"
                                                            value="{{ $test->id }}" />
                                                        <input type="hidden" name="subject_id"
                                                            value="{{ $test->subject_id }}" />
                                                    </p>
                                                    <p>Instruction:
                                                        <span id="instructionId" class="font-weight-bold"
                                                            onclick="editInstruction(this, 'instructionId')">
                                                            {{ strip_tags($test->instruction) ?? 'Enter instructions. ' }}
                                                        </span>
                                                        <input type="hidden" value="{{ $test->instruction }}"
                                                            name="instructions" id="instructionIdValue" />
                                                    </p>
                                                </div>
                                                <p class="text-right pr-3" style="position: static">
                                                    <span id="edit-duration" class="font-weight-bold"
                                                        onclick="editDuration(this)">
                                                        {{ $test->duration ?? 0 }}
                                                    </span>
                                                    seconds
                                                </p>

                                                <input type="hidden" value="{{ $test->duration }}" name="duration"
                                                    id="durationIdValue" />


                                                @foreach ($test->questions as $questionIndex => $quest)
                                                    <div class="card-body" id="question{{ $questionIndex }}">
                                                        <div class="card">
                                                            <div class="card-body question-count">
                                                                <h4 class="card-title mb-2">
                                                                    <span class="question-number">{{ $loop->iteration }}</span>. <span
                                                                        id="question-{{ $loop->iteration }}"
                                                                        onclick="editText(this, 'question-{{ $loop->iteration }}')">
                                                                        {!! $quest->question !!} </span>
                                                                    <input type="hidden"
                                                                        name="questions[{{ $questionIndex }}][text]"
                                                                        value="{{ $quest->question }}"
                                                                        id="questionValue-question-{{ $loop->iteration }}" />
                                                                    <input type="hidden"
                                                                        name="questions[{{ $questionIndex }}][type]"
                                                                        value="{{ $quest->type }}" />

                                                                    @if ($quest->image)
                                                                        <div class="m-2">
                                                                            <img src="/storage/images/questions/{{ $quest->image->name }}"
                                                                                alt="{{ $quest->image->name }}"
                                                                                height="100" width="200"
                                                                                class="img-fluid border">
                                                                        </div>
                                                                    @endif
                                                                </h4>
                                                                <small id="point-{{ $loop->iteration }}"
                                                                    class="float-right font-weight-bold">
                                                                    <span class="edit-point"
                                                                        onclick="editPoint(this,{{ $questionIndex }})">{{ $quest->point }}</span>
                                                                    point(s)
                                                                </small>

                                                                <input type="hidden"
                                                                    name="questions[{{ $questionIndex }}][points]"
                                                                    id="question-{{ $questionIndex }}-point"
                                                                    value="{{ $quest->point }}" />

                                                                @foreach ($quest->options as $optionIndex => $option)
                                                                    <p class="card-text pl-3 options">
                                                                        @if ($quest->type == $option_type)
                                                                            <input type="hidden"
                                                                                name="questions[{{ $questionIndex }}][options][{{ $optionIndex }}][text]"
                                                                                value="{{ $option->label ?? ($option->image->name ?? '') }}"
                                                                                id="optionValue-question-{{ $questionIndex }}option-{{ $optionIndex }}">
                                                                            <input type="hidden"
                                                                                name="questions[{{ $questionIndex }}][options][{{ $optionIndex }}][is_correct]"
                                                                                value="{{ $option->is_correct }}"
                                                                                id="is-correct-option-{{ $optionIndex }}-question-{{ $questionIndex }}">
                                                                            <input type="radio"
                                                                                name="questions[{{ $questionIndex }}][selected_option]"
                                                                                {{ $option->is_correct ? 'checked' : '' }}
                                                                                value="{{ $optionIndex }}"
                                                                                onclick="updateIsCorrect(this,'is-correct-option-{{ $optionIndex }}-question-{{ $questionIndex }}')">

                                                                            <span
                                                                                onclick="editOption(this, 'question-{{ $questionIndex }}option-{{ $optionIndex }}')"
                                                                                id="question-{{ $questionIndex }}option-{{ $optionIndex }}">
                                                                                {{ $option->label }}
                                                                            </span>

                                                                            @if ($option->image)
                                                                                <img src="/storage/images/options/{{ $option->image->name }}"
                                                                                    alt="{{ $option->image->name }}"
                                                                                    height="50" width="100"
                                                                                    class="img-fluid border">
                                                                            @endif
                                                                        @elseif($quest->type == $multi_choice_type)
                                                                            <input type="hidden"
                                                                                name="questions[{{ $questionIndex }}][options][{{ $optionIndex }}][text]"
                                                                                value="{{ $option->label ?? ($option->image->name ?? '') }}"
                                                                                id="optionValue-question-{{ $questionIndex }}option-{{ $optionIndex }}">
                                                                            <input type="hidden"
                                                                                name="questions[{{ $questionIndex }}][options][{{ $optionIndex }}][is_correct]"
                                                                                value="{{ $option->is_correct }}"
                                                                                id="is-correct-option-{{ $optionIndex }}-question-{{ $questionIndex }}">
                                                                            <input type="checkbox"
                                                                                name="questions[{{ $questionIndex }}][selected_option][]"
                                                                                 value="{{ $optionIndex }}"
                                                                                {{ $option->is_correct ? 'checked' : '' }}
                                                                                onclick="updateIsCorrect(this,'is-correct-option-{{ $optionIndex }}-question-{{ $questionIndex }}')"
                                                                                >

                                                                            <span
                                                                                onclick="editOption(this, 'question-{{ $questionIndex }}option-{{ $optionIndex }}')"
                                                                                id="question-{{ $questionIndex }}option-{{ $optionIndex }}">
                                                                                {{ $option->label }}
                                                                            </span>
                                                                            @if ($option->image)
                                                                                <img src="/storage/images/options/{{ $option->image->name }}"
                                                                                    alt="{{ $option->image->name }}"
                                                                                    height="50" width="100"
                                                                                    class="img-fluid border">
                                                                            @endif
                                                                        @elseif($quest->type == $no_option)
                                                                            <input type="text"
                                                                                class="border-top-0 border-right-0 border-left-0"
                                                                                style="width:90%"
                                                                                name="questions[{{ $questionIndex }}][options][{{ $optionIndex }}][text]"
                                                                                value="{{ $option->is_correct ? $option->label : '' }}"
                                                                                id="answer-id" autocomplete="off">
                                                                            <input type="hidden"
                                                                                name="questions[{{ $questionIndex }}][options][{{ $optionIndex }}][is_correct]"
                                                                                value="{{ $option->is_correct ?? 1 }}"
                                                                                id="answer-id">
                                                                        @endif
                                                                    </p>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="text-right m-1 p-1 "
                                                            title="delete question {{ $loop->iteration }}"
                                                            style="cursor: pointer"
                                                            onclick="deleteQuestion({{ $quest }},{{ $questionIndex }})">
                                                            <i class="fa fa-minus  border"></i>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <input type="hidden" value="{{ $test->id }}" name="test_id">
                                            </div>

                                        </div>

                                        <div class="col-md-12 m-3 text-center">
                                            <button type="submit" class="btn btn-success"
                                                id="submitButton">Save</button>
                                        </div>

                                        <div class="text-center">
                                            <span>Last saved on {{ $test->updated_at }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                    <footer style="position: relative; display: flex; justify-content: center;" class="container">
                        <div style="position: fixed; bottom: 0;">
                            <div class="card">
                                <div class="card-body " style="background:rgba(24,57,46)">
                                    <div>
                                        <button type="button" class="btn border text-white"
                                            id="optionType">Option</button>
                                        <button type="button" class="btn border text-white"
                                            id="multichoiceType">Multiple Choice</button>
                                        <button type="button" class="btn border text-white" id="no-optionType">Fill
                                            in the blank</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </footer>

                </div>
                <!-- /.container-fluid -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

    </div>


    <!-- question -->
    <div id="edit-modal" class="modal animated rubberBand edit-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea name="question" id="question" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="update" onclick="updateText()"
                        class="btn btn-success">Save</button>
                    <button type="button" id="cancel" class="btn btn-danger"
                        data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <!-- option -->
    <div id="edit-option-modal" class="modal animated rubberBand edit-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea name="option" id="option" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="update" onclick="updateOption()"
                        class="btn btn-success">Save</button>
                    <button type="button" id="cancel" class="btn btn-danger"
                        data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <!-- instruction -->
    <div id="edit-instruction-modal" class="modal animated rubberBand edit-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea name="instruction" id="instruction" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="update-instruction" onclick="updateInstructionText()"
                        class="btn btn-success">Save</button>
                    <button type="button" id="cancel" class="btn btn-danger"
                        data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    @include('admin.partials.footer')
    <script>
        function editText(element, questionId) {
            const text = $(element).text();
            CKEDITOR.instances.question.setData(text);
            $('#edit-modal').modal('show');
            $('#update').data('question-id', questionId);
        }

        function updateText() {
            const newText = CKEDITOR.instances.question.getData();
            const plainText = $(newText).text();
            const questionId = $('#update').data('question-id');
            console.log(questionId);
            $(`#${questionId}`).text(plainText);
            $(`#questionValue-${questionId}`).val(plainText);
            $('#edit-modal').modal('hide');
        }


        function editOption(element, questionOptionId) {
            const text = $(element).text();
            CKEDITOR.instances.option.setData(text);
            $('#edit-option-modal').modal('show');
            $('#update').data('option-id', questionOptionId);
        }

        function updateOption() {
            const newText = CKEDITOR.instances.option.getData();
            const plainText = $(newText).text();
            const optionId = $('#update').data('option-id');
            console.log(optionId);
            $(`#${optionId}`).text(plainText);
            $(`#optionValue-${optionId}`).val(plainText);
            $('#edit-option-modal').modal('hide');
        }


        function editPoint(element, questionIndex) {
            let pointSpan = $(element);
            let pointValue = pointSpan.text();
            console.log(questionIndex);
            let inputField = $('<input>', {
                type: 'number',
                value: pointValue,
                class: 'form-control',
                required: true
            });

            pointSpan.replaceWith(inputField);
            inputField.focus();

            inputField.blur(function() {
                let newPointValue = $(this).val();
                if (newPointValue === '' || isNaN(newPointValue)) {
                    newPointValue = 1;
                }

                $(`#question-${questionIndex}-point`).val(newPointValue);
                savePoint($(this).parent(), newPointValue, questionIndex);
            });

        }

        function savePoint(parentElement, newPointValue, quesIndex) {
            var pointSpan = $('<span>', {
                text: newPointValue,
                class: 'font-weight-bold',
                click: function() {
                    editPoint($(this), quesIndex);
                }
            });

            parentElement.empty();
            parentElement.append(pointSpan);
            parentElement.append(" point(s)");
        }

        $('.edit-point').click(function() {
            editPoint($(this));
        });


        //edit duration
        function editDuration(element) {
            let durationSpan = $(element);
            let durationValue = durationSpan.text();

            console.log(typeof(parseInt(durationValue)));

            let inputField = $('<input>', {
                type: 'number',
                value: parseInt(durationValue),
                class: 'form-control',
                style: 'margin: 0 15px;',
                required: true
            });

            durationSpan.replaceWith(inputField);
            inputField.focus();

            inputField.blur(function() {
                let newDurationValue = $(this).val();
                if (newDurationValue === '' || isNaN(newDurationValue)) {
                    newDurationValue = 1;
                }

                $('#durationIdValue').val(newDurationValue);

                saveDuration($(this).parent(), newDurationValue);
            });
        }


        //save duration
        function saveDuration(parentElement, newDurationValue) {
            let durationSpan = $('<span>', {
                text: newDurationValue,
                class: 'font-weight-bold',
                click: function() {
                    editDuration($(this));
                }
            });

            parentElement.empty();
            parentElement.append(durationSpan);
            parentElement.append(" seconds");
            console.log(newDurationValue);
        }

        $('#edit-duration').click(function() {
            editDuration($(this));
        });



        //edit instructions
        function editInstruction(element, instructionId) {
            const text = $(element).text();
            CKEDITOR.instances.instruction.setData(text);
            $('#edit-instruction-modal').modal('show');
            $('#update-instruction').data('instruction-id', instructionId);
        }

        function updateInstructionText() {
            const newText = CKEDITOR.instances.instruction.getData();
            const plainText = $(newText).text();
            const instructionId = $('#update-instruction').data('instruction-id');
            $(`#${instructionId}`).text(plainText);
            $('#instructionIdValue').val(plainText);
            $('#edit-instruction-modal').modal('hide');
        }


        function updateIsCorrect(radioButton, isCorrectInputId) {
            let isChecked = $(radioButton).is(":checked");
            console.log(isChecked, isCorrectInputId);
            $(`#${isCorrectInputId}`).val(isChecked ? 1 : 0);
            console.log($(`#${isCorrectInputId}`).val());
        }

        $('#instructionIdValue').val($('#instructionId').text());
        $('#durationIdValue').val($('#edit-duration').text());


        $('#optionType').on('click', function() {
            let newQuestionIndex = $('.question-count').length;
            let incrementQuestionIndex = newQuestionIndex + 1;
            let newQuestionCard = `
        <div class="card-body" id="question${ newQuestionIndex }">
            <div class="card">
                <div class="card-body question-count">
                    <h4 class="card-title mb-2">
                        <span class="question-number">${incrementQuestionIndex } </span>. <span id="question-${incrementQuestionIndex }" onclick="editText(this, 'question-${incrementQuestionIndex }')">
                            Enter question text here
                        </span>
                        <input type="hidden" name="questions[${newQuestionIndex}][text]" value="" id="questionValue-question-${incrementQuestionIndex }" />
                        <input type="hidden" name="questions[${newQuestionIndex}][type]" value="option" />
                    </h4>
                    <small id="point-${incrementQuestionIndex }" class="float-right font-weight-bold">
                        <span class="edit-point" onclick="editPoint(this,${incrementQuestionIndex})">1</span> point(s)
                    </small>
                    <input type="hidden" name="questions[${newQuestionIndex}][points]" id="question-${incrementQuestionIndex }-point" value="1" />
                    
                    <!-- Add option fields here -->
                    <div class="options">
                        <!-- Option 1 -->
                        <p class="card-text pl-3 options">
                             <input type="hidden" name="questions[${newQuestionIndex}][options][0][text]"
                                    value="" id="optionValue-question-${newQuestionIndex}option-0">
                            <input type="hidden" name="questions[${newQuestionIndex}][options][0][is_correct]" value="0"
                                    id="is-correct-option-0-question-${newQuestionIndex}">
                            <input type="radio" name="questions[${newQuestionIndex}][selected_option]" value="0" onclick="updateIsCorrect(this,'is-correct-option-0-question-${newQuestionIndex}')">
                            <span onclick="editOption(this, 'question-${newQuestionIndex}option-0')" id="question-${newQuestionIndex}option-0">Option 1</span>
                        </p>
                        <!-- Option 2 -->
                        <p class="card-text pl-3 options">
                             <input type="hidden" name="questions[${newQuestionIndex}][options][1][text]"
                                    value="" id="optionValue-question-${newQuestionIndex}option-1">
                            <input type="hidden" name="questions[${newQuestionIndex}][options][1][is_correct]"
                                 value="0" id="is-correct-option-1-question-${newQuestionIndex}">
                            <input type="radio" name="questions[${newQuestionIndex}][selected_option]" value="1" onclick="updateIsCorrect(this,'is-correct-option-1-question-${newQuestionIndex}')">
                            <span onclick="editOption(this, 'question-${newQuestionIndex}option-1')" id="question-${newQuestionIndex}option-1">Option 2</span>
                        </p>
                        <!-- Option 3 -->
                        <p class="card-text pl-3 options">
                             <input type="hidden" name="questions[${newQuestionIndex}][options][2][text]"
                                    value="" id="optionValue-question-${newQuestionIndex}option-2">
                            <input type="hidden" name="questions[${newQuestionIndex}][options][2][is_correct]"
                                  value="0" id="is-correct-option-2-question-${newQuestionIndex}">
                            <input type="radio" name="questions[${newQuestionIndex}][selected_option]" value="2"   onclick="updateIsCorrect(this,'is-correct-option-2-question-${newQuestionIndex}')">
                            <span onclick="editOption(this, 'question-${newQuestionIndex}option-2')" id="question-${newQuestionIndex}option-2">Option 3</span>
                        </p>
                          <p class="card-text pl-3 options">
                             <input type="hidden" name="questions[${newQuestionIndex}][options][3][text]"
                                    value="" id="optionValue-question-${newQuestionIndex}option-3">
                            <input type="hidden" name="questions[${newQuestionIndex}][options][3][is_correct]"
                                  value="0" id="is-correct-option-3-question-${newQuestionIndex}">
                            <input type="radio" name="questions[${newQuestionIndex}][selected_option]" value="3" onclick="updateIsCorrect(this,'is-correct-option-3-question-${newQuestionIndex}')">
                            <span onclick="editOption(this, 'question-${newQuestionIndex}option-3')" id="question-${newQuestionIndex}option-3">Option 4</span>
                        </p>
                        <!-- Add more options if needed -->
                    </div>
                </div>
            </div>

             <div class="text-right m-1 p-1 " title="delete question ${incrementQuestionIndex}"
                    style="cursor: pointer"
                    onclick="deleteQuestion(null,${incrementQuestionIndex})">
                    <i class="fa fa-minus  border"></i>
            </div>
        </div>
    `;

            $('.main-card').append(newQuestionCard);
        });




        $('#multichoiceType').on('click', function() {
            let newQuestionIndex = $('.question-count').length;
            let incrementQuestionIndex = newQuestionIndex + 1;

            let newQuestionCard = `
        <div class="card-body"  id="question${incrementQuestionIndex}">
            <div class="card">
                <div class="card-body question-count">
                    <h4 class="card-title mb-2">
                        <span class="question-number">${incrementQuestionIndex }</span>. <span id="question-${incrementQuestionIndex}" onclick="editText(this, 'question-${incrementQuestionIndex}')">
                            Enter question text here
                        </span>
                        <input type="hidden" name="questions[${newQuestionIndex}][text]" value="" id="questionValue-question-${incrementQuestionIndex}" />
                        <input type="hidden" name="questions[${newQuestionIndex}][type]" value="multiple choice" />
                    </h4>

                     <small id="point-${incrementQuestionIndex}" class="float-right font-weight-bold">
                        <span class="edit-point" onclick="editPoint(this,${incrementQuestionIndex})">1</span> point(s)
                    </small>
                    <input type="hidden" name="questions[${newQuestionIndex}][points]" id="question-${incrementQuestionIndex}-point" value="1" />

                    <!-- Options -->
                    <div class="options">
                        <!-- Option 1 -->
                        <p class="card-text pl-3 options">
                            <input type="hidden" name="questions[${newQuestionIndex}][options][0][text]" value="" id="optionValue-question-${incrementQuestionIndex}option-0">
                            <input type="hidden" name="questions[${newQuestionIndex}][options][0][is_correct]" value="0" id="is-correct-option-0-question-${incrementQuestionIndex}">
                            <input type="checkbox" name="questions[${newQuestionIndex}][selected_options][]" value="0" onclick="updateIsCorrect(this,'is-correct-option-0-question-${incrementQuestionIndex}')">
                            <span onclick="editOption(this, 'question-${newQuestionIndex}option-0')" id="question-${incrementQuestionIndex}option-0">Option 1</span>
                        </p>
                        <!-- Option 2 -->
                        <p class="card-text pl-3 options">
                            <input type="hidden" name="questions[${newQuestionIndex}][options][1][text]" value="" id="optionValue-question-${incrementQuestionIndex}option-1">
                            <input type="hidden" name="questions[${newQuestionIndex}][options][1][is_correct]" value="0" id="is-correct-option-1-question-${incrementQuestionIndex}">
                            <input type="checkbox" name="questions[${newQuestionIndex}][selected_option][]" value="1" onclick="updateIsCorrect(this,'is-correct-option-1-question-${incrementQuestionIndex}')">
                            <span onclick="editOption(this, 'question-${newQuestionIndex}option-1')" id="question-${incrementQuestionIndex}option-1">Option 2</span>
                        </p>
                        <!-- Option 3 -->
                        <p class="card-text pl-3 options">
                            <input type="hidden" name="questions[${newQuestionIndex}][options][2][text]" value="" id="optionValue-question-${incrementQuestionIndex}option-2">
                            <input type="hidden" name="questions[${newQuestionIndex}][options][2][is_correct]" value="0" id="is-correct-option-2-question-${incrementQuestionIndex}">
                            <input type="checkbox" name="questions[${newQuestionIndex}][selected_option][]" value="2" onclick="updateIsCorrect(this,'is-correct-option-2-question-${incrementQuestionIndex}')">
                            <span onclick="editOption(this, 'question-${newQuestionIndex}option-2')" id="question-${incrementQuestionIndex}option-2">Option 3</span>
                        </p>
                        <!-- Option 4 -->
                        <p class="card-text pl-3 options">
                            <input type="hidden" name="questions[${newQuestionIndex}][options][3][text]" value="" id="optionValue-question-${incrementQuestionIndex}option-3">
                            <input type="hidden" name="questions[${newQuestionIndex}][options][3][is_correct]" value="0" id="is-correct-option-3-question-${incrementQuestionIndex}">
                            <input type="checkbox" name="questions[${newQuestionIndex}][selected_option][]" value="3" onclick="updateIsCorrect(this,'is-correct-option-3-question-${incrementQuestionIndex}')">
                            <span onclick="editOption(this, 'question-${newQuestionIndex}option-3')" id="question-${incrementQuestionIndex}option-3">Option 4</span>
                        </p>
                        <!-- Add more options if needed -->
                    </div>
                </div>
            </div>
             <div class="text-right m-1 p-1 " title="delete question ${incrementQuestionIndex}"
                    style="cursor: pointer"
                    onclick="deleteQuestion(null,${incrementQuestionIndex})">
                    <i class="fa fa-minus  border"></i>
            </div>
        </div>
    `;

            $('.main-card').append(newQuestionCard);
        });



        $("#no-optionType").on('click', function() {
            let newQuestionIndex = $('.question-count').length;
            let incrementQuestionIndex = newQuestionIndex + 1;

            let newQuestionCard = `
        <div class="card-body " id="question${ incrementQuestionIndex }">
            <div class="card">
                <div class="card-body question-count">
                    <h4 class="card-title mb-2">
                       <span class="question-number">${incrementQuestionIndex}</span>. <span id="question-${incrementQuestionIndex}" onclick="editText(this, 'question-${incrementQuestionIndex}')">
                            Enter question text here
                        </span>
                        <input type="hidden" name="questions[${newQuestionIndex}][text]" value="" id="questionValue-question-${incrementQuestionIndex}" />
                        <input type="hidden" name="questions[${newQuestionIndex}][type]" value="no_option" />
                    </h4>

                     <small id="point-${incrementQuestionIndex}" class="float-right font-weight-bold">
                        <span class="edit-point" onclick="editPoint(this,${incrementQuestionIndex})">1</span> point(s)
                    </small>
                    <input type="hidden" name="questions[${newQuestionIndex}][points]" id="question-${incrementQuestionIndex}-point" value="1" />

                    <!-- Answer input field -->
                    <div class="form-group">
                          <input type="hidden" name="questions[${newQuestionIndex}][options][0][is_correct]"
                                value="1" id="answer-id">
                        <input type="text" class="form-control border-top-0 border-right-0 border-left-0" name="questions[${newQuestionIndex}][options][0][text]" placeholder="Enter answer...">
                    </div>
                </div>
            </div>

             <div class="text-right m-1 p-1 " title="delete question ${incrementQuestionIndex}"
                    style="cursor: pointer"
                    onclick="deleteQuestion(null,${incrementQuestionIndex})">
                    <i class="fa fa-minus  border"></i>
            </div>
        </div>
    `;

            // Append the new no-option question card below the last existing card
            $('.main-card').append(newQuestionCard);
        });

        async function deleteQuestion(question = null, questionIndex) {
            $(`#question${questionIndex}`).remove();
            console.log(question, questionIndex);

            if (question && question != "null") {
                try {
                    const response = await $.post(`api/delete-question/${question.id}`);
                    alert('Question deleted successfully');
                    console.log('Delete response:', response);
                } catch (error) {
                    console.error('Error deleting question:', error);
                    alert('Failed to delete question. Please try again.');
                }
            } else {
                console.warn('No question object provided.');
            }
            updateQuestionSerialNumbers();
        }

        function updateQuestionSerialNumbers() {
            const $questionRows = $('.question-count');

            // Loop through each question row using each()
            $questionRows.each(function(index) {
                console.log(index);
                // Update the serial number directly
                $(this).find('.question-number').text(index + 1);
            });
        }
    </script>
</body>

</html>
