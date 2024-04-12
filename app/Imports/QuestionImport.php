<?php

namespace App\Imports;

use Exception;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionImport implements ToCollection, WithHeadingRow
{

    public function __construct(private $subjectId)
    {
        
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collections)
    {

        foreach ($collections as $collection) {
            $collection->each(function ($item, string $key) use ($collection) {

                if (strtolower($key) === 'types' && $item === Question::OPTION) {
                    $this->optionType($collection);
                } else if (strtolower($key) === 'types' && $item === Question::MULTI_CHOICE) {
                    $this->multipleChoice($collection);
                } else if (strtolower($key) === 'types' && $item === Question::NO_OPTION) {
                    $this->noOption($collection);
                }
            });
        }
    }


    private function optionType(Collection $collection)
    {
        try {
            DB::beginTransaction();

            $question= $this->createQuestion($collection);

            $optionKeys = $collection->filter(function ($item, $key) {
                return str_starts_with($key, 'option');
            });

            $collectionAnswer = $collection['answers'];
            $answer = 1;

            foreach ($optionKeys as $item) {
                $option = new Option();
                $option->question_id = $question->id;
                $option->label = $this->removeBreaks($item);

                if ($answer == $collectionAnswer) {
                    $option->is_correct = true;
                } else {
                    $option->is_correct = false;
                }

                $answer++;
                $option->save();
            }
            DB::commit();
        } catch (Exception $ex) {
            throw new Exception('An error encountered while trying to upload Question');
            DB::rollBack();
        }
    }


    private function multipleChoice(Collection $collection)
    {
        try {
            DB::beginTransaction();

            $question= $this->createQuestion($collection);

            $optionKeys = $collection->filter(function ($item, $key) {
                return str_starts_with($key, 'option');
            });

            $collectionAnswer = $collection['answers'];

            $answer = 1;
            foreach ($optionKeys as $item) {
                $option = new Option();
                $option->question_id = $question->id;
                $option->label = $this->removeBreaks($item);

                $answerArray = explode(',', $collectionAnswer);

                if (in_array($answer, $answerArray)) {
                    $option->is_correct = true;
                } else {
                    $option->is_correct = false;
                }
                $answer++;


                $option->save();
            }

            DB::commit();
        } catch (Exception $ex) {
            throw new Exception('An error encountered while trying to upload Question');
            DB::rollBack();
        }
    }



    private function noOption(Collection $collection)
    {
        try {
            DB::beginTransaction();

            $question = $this->createQuestion($collection);

            $option = new Option();
            $option->question_id = $question->id;
            $option->label = $this->removeBreaks($collection['answers']);
            $option->is_correct = true;
            $option->save();

            DB::commit();
        } catch (Exception $ex) {
            throw new Exception('An error encountered while trying to upload Question');
            DB::rollBack();
        }
    }


    public function createQuestion(Collection $collection){
        return Question::create([
            'question' => $collection['questions'],
            'subject_id' => $this->subjectId,
            'type' => $collection['types'],
            'point' => $collection['points'],
        ]);
    }


    private function removeBreaks(String $str){
       $newstr = str_replace("\r\n","", $str);
       return trim($newstr, "\r\n");
    }
}
