<?php

namespace App\Http\Requests\Videos;

use App\Helpers\CustomFormRequest;

class StoreVideo extends CustomFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'title' => 'bail|required|max:255|unique:videos',

            // 'title' => 'bail|required|max:255',

            'category' => 'bail|required|max:255',

            'description' => 'bail|required',

            'video_file[]' => 'file'


        ];
    }
}
