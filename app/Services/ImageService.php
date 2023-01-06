<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * proces and store Image 
     * @param  \Illuminate\Http\Request  $request
     */
    public function storeQuestionImage(Question $question, $image)
    {
        $new_image = new Image();
        if ($image) {
            $image_name = date('YmdHi') . $image->getClientOriginalName();
            Storage::disk('local')->putFileAs(
                'public/images/questions',
                $image,
                $image_name
            );
            // $image->move(public_path('/public/images'),$image_name);
            $new_image['name'] = $image_name;
            $new_image['imageable_type'] = "App\Models\Question";
            $new_image['imageable_id']  = $question->id;
        }
        $new_image->save();
        $question->image()->save($new_image);
    }


    /**
     * store Option image
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function storeOptionImage(Option $option, $image)
    {
        $option_image = new Image();
        if ($image) {
            $image_name = date('YmdHi') . $image->getClientOriginalName();
            Storage::disk('local')->putFileAs(
                'public/images/options',
                $image,
                $image_name
            );
            // $image->move(public_path('/public/images'),$image_name);
            $option_image['name'] = $image_name;
            $option_image['imageable_type'] = "App\Models\Option";
            $option_image['imageable_id']  = $option->id;
        }
        $option_image->save();
        $option->image()->save($option_image);
    }

    /**
     * proces and update question Image 
     * @param  \Illuminate\Http\Request  $request
     */
    public function updateQuestionImage(Question $question, $image)
    {
        $get_image = Image::where(['imageable_id' => $question->id, 'imageable_type' => 'App\Models\Question'])->first();
        if (!$get_image) {
            $this->storeQuestionImage($question, $image);
        } else {
            $image_name = $this->updateImage($get_image->name, $image, 'public/images/questions');

            if ($image_name) {
                $get_image->name = $image_name;
                $get_image->save();
            }
        }
    }


    /**
     * update Option Image
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function updateOptionImage(Option $option, $image)
    {
        $get_option = Image::where(['imageable_id' => $option->id, 'imageable_type' => 'App\Models\Option'])->first();

        if (!$get_option) {
            $this->storeOptionImage($option, $image);
        } else {
            $image_name = $this->updateImage($get_option->name, $image, 'public/images/options');

            if ($image_name) {
                $get_option->name = $image_name;
                $get_option->save();
            }
        }
    }


    public function updateImage($previous_image_name, $new_image, $path)
    {

        $prev_image = public_path($path) . $previous_image_name;

        if (file_exists($prev_image)) {
            Image::where('name', $previous_image_name)->delete();
            @unlink($prev_image); // then delete previous photo 
        }

        $image_name = date('YmdHi') . $new_image->getClientOriginalName();
        Storage::disk('local')->putFileAs(
            $path,
            $new_image,
            $image_name
        );

        return $image_name;
    }
}
