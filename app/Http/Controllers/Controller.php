<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function saveAttachment($request, $model, $field = 'attachment')
    {
        if ($request->hasFile($field)) {

          foreach ($request[$field] as $attachment) {
            $model->addMedia($attachment)->withResponsiveImages()->toMediaCollection();
          }

        }
    }
}
