<?php

namespace App\Http\Requests\Exports;

use App\Helpers\CustomFormRequest;

class StoreExport extends CustomFormRequest
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
            'agent_name' => 'bail|required',
            'date' => 'bail|required|date|max:100',
        ];
    }
}
