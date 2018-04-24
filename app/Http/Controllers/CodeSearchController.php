<?php

namespace App\Http\Controllers;


use App\Code;
use Illuminate\Http\Request;

use App\Http\Requests\Codes\StoreCode;
use App\Http\Requests\Codes\UpdateCode;

use App\Helpers\EasyuiPagination;

class CodeSearchController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); // allow creating through admin only
    }

    public function index()
    {
    	return view('home');
    }

    public function listCodes()
    {
      return Code::distinct('name')->limit(10)->get(['name']);
    }

    public function search($code) {

    	if(!\Auth::usert()->hasRole('Premium') && $this->exceededMaxSearch()) {

			return view('search_codes.exceeded_max_search');

		}

		$code = Code::where('code', $code)->first();

		if(!$code->exists) {

			return view('search_codes.does_not_exist');

		}

		return view('search_codes.show_code_detail');



    }

    private function exceededMaxSearch()
    {

    	$countSearches = \Auth::user()->codeSearches()->where('date', date("Y-m-d"))->count();

    	return ($countSearches >= 5);

    }



}
