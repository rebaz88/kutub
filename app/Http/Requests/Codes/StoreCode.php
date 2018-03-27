<?php

namespace App\Http\Requests\Codes;

use App\Helpers\CustomFormRequest;

class StoreCode extends CustomFormRequest
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

            'name' => 'bail|required|max:255|unique:codes',

            'category' => 'bail|required|max:255',

            'description' => 'bail|required',


        ];
    }
}
