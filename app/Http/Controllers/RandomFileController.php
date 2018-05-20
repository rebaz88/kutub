<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RandomFile;

class RandomFileController extends Controller
{
  public function saveRandomFile(Request $request)
  {
    $randomFile = RandomFile::create([]);
    $this->saveAttachment($request, $randomFile);
    return $randomFile->getFirstMediaUrl();
  }

}
