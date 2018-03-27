<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Expenditure;
use App\Helpers\EasyuiPagination;

class ExpenditureController extends Controller
{

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	return view('expenditures.index');
    }

    public function list(Request $request)
    {

        $query = Expenditure::query();

        // Sort by date
        if($request->has('sort')) {
            $query->orderBy('expenditures.'.$request->sort, $request->order);
        }

      //Regular sort
      $query->orderBy('expenditures.date', 'desc');

      if($request->has('filterRules')) {

        $filterRules = json_decode($request->filterRules);

        foreach ($filterRules as $filterRule) {

          if($filterRule->field == 'filter_by_date')
          {
            $query->whereBetween('date', [toMysqlDate($filterRule->filter_from),toMysqlDate($filterRule->filter_to)]);
          }
          elseif($filterRule->field == 'note')
          {
            $query->where('expenditures.note', 'like', '%'. $filterRule->value .'%');
          }
          else
          {
            $query->where($filterRule->field, 'like', '%'. $filterRule->value .'%');
          }
        }
      }


      $result = EasyuiPagination::paginageData($request, $query);

      // Expenditure::$withoutAppends = true;
      $footer = ['footer' => Expenditure::select([\DB::raw('SUM(amount) as amount')])->get(['type', 'amount'])];

      return array_merge($result, $footer);
    }

    public function insert(Request $request)
    {

        $expenditure = Expenditure::create([
    			'type' => $request->type,
    			'detail' => $request->detail,
    			'amount' => $request->amount,
    			'officer' => $request->officer,
    			'date' => toMysqlDate($request->date),
    			'note' => $request->note,
        ]);

        $this->saveAttachment($request, $expenditure);

        return ezReturnSuccessMessage('Expenditure saved successfully');
    }

    public function update(Request $request)
    {
        $expenditure = Expenditure::findOrFail($request->id);

		    $expenditure->type = $request->type;
		    $expenditure->detail = $request->detail;
		    $expenditure->amount = $request->amount;
		    $expenditure->officer = $request->officer;
		    $expenditure->date = toMysqlDate($request->date);
		    $expenditure->note = $request->note;

        $expenditure->save();

        $this->saveAttachment($request, $expenditure);

        return ezReturnSuccessMessage('Expenditure updated successfully');

    }

    private function saveAttachment(Request $request, Expenditure $expenditure)
    {
        if ($request->hasFile('attachment')) {

            $expenditure->clearMediaCollection();

            $expenditure->addMedia($request->attachment)
                       ->preservingOriginal()
                       ->toMediaCollection();
        }
    }

    public function destroy(Request $request)
    {

        $expenditure = Expenditure::find($request->id);

        $expenditure->clearMediaCollection();

        $expenditure->delete();

        return ezReturnSuccessMessage('Expenditure deleted successfully');

    }

    public function getTypeList(Request $request)
    {
        Expenditure::$withoutAppends = true;
        return Expenditure::distinct('type')->get(['type']);
    }

    public function getDetailList(Request $request)
    {
        if(!$request->has('type'))
            return [];

        Expenditure::$withoutAppends = true;

        $q = ($request->has('q')) ? $request->q : '';

        $details = Expenditure::where('detail', 'like', "%{$q}%")
                        ->where('type', $request->type)
                        ->distinct('detail')
                        ->get(['detail']);

        return $details;
    }


}
