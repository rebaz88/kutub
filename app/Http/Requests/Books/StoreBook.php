<?php

namespace App\Http\Requests\Books;

use App\Helpers\CustomFormRequest;

class StoreBook extends CustomFormRequest
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

            'title' => 'bail|required|max:255|unique:books',

            // 'title' => 'bail|required|max:255',

            'category' => 'bail|required|max:255',

            'author' => 'bail|required|max:255',

            'description' => 'bail|required',

            'book_image[]' => 'bail|image',

            'book_file[]' => 'mimes:pdf'


        ];
    }
}
