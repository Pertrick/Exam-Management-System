<?php

namespace App\Exports;

use App\Models\Test;
use App\Models\Question;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class QuestionExport implements FromView
{
    public function __construct(private Test $test, private Collection $questions)
    {
        
    }
    public function view(): View
    {
        return view('admin.test.export', [
            'questions' => $this->questions,
            'test' => $this->test,
            'option_type' => Question::OPTION,
            'multi_choice_type' => Question::MULTI_CHOICE,
            'no_option' => Question::NO_OPTION
        ]);
    }
}
