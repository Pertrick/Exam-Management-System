<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ResultsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    public function collection()
    {
        return $this->results;
    }

    public function headings(): array
    {
        return [
            'Subject',
            'Student Name',
            'Email',
            'Score',
            'Total Questions',
            'Percentage',
            'Started On',
            'Finished On',
            'Duration'
        ];
    }

    public function map($result): array
    {
        $duration = 'N/A';
        if ($result->start_time && $result->end_time) {
            $start = \Carbon\Carbon::parse($result->start_time);
            $end = \Carbon\Carbon::parse($result->end_time);
            $diff = $end->diff($start);
            $duration = sprintf('%02d:%02d:%02d', $diff->h + $diff->d * 24, $diff->i, $diff->s);
        }

        return [
            $result->subject_name,
            $result->user_name,
            $result->user_email,
            $result->correct_answers,
            $result->total_questions,
            number_format($result->score_percentage, 2) . '%',
            $result->start_time ? \Carbon\Carbon::parse($result->start_time)->format('M d, Y H:i') : 'N/A',
            $result->end_time ? \Carbon\Carbon::parse($result->end_time)->format('M d, Y H:i') : 'N/A',
            $duration
        ];
    }
}