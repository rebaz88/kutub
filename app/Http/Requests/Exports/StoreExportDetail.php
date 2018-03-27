<?php

namespace App\Http\Requests\Exports;

use App\Helpers\CustomFormRequest;

class StoreExportDetail extends CustomFormRequest
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

            'export_id' => 'bail|required',
            'name' => 'bail|required',
            'size' => 'bail|required',
            'color' => 'bail|required',
            'quantity' => 'bail|required',
            'original_price' => 'bail|required',
            'unit_price' => 'bail|required',
            'discount' => 'bail|required',
            'total' => 'bail|required',

        ];
    }
}
