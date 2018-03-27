<?php

namespace App\Http\Requests\Items;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\CustomFormRequest;

class UpdateItem extends CustomFormRequest
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

            'name' => 'bail|required|max:100|unique_with:items,size,color,'.$this->get('id'),

            'size' => 'bail|required|max:10',

            'color' => 'bail|required|max:15',


        ];
    }
}
