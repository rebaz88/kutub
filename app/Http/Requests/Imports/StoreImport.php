<?php

namespace App\Http\Requests\Imports;

use App\Helpers\CustomFormRequest;

class StoreImport extends CustomFormRequest
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

            'invoice' => 'bail|required|max:100',
            'date' => 'bail|required|date|max:100',
            'type' => 'bail|required',
            'port' => 'bail|required',
            'container' => 'bail|required',
            'vendor' => 'bail|required|max:100',


        ];
    }
}
