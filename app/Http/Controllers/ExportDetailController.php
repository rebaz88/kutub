<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Export;
use App\ExportDetail;
use App\Item;
use App\Http\Requests\Exports\StoreExportDetail;

class ExportDetailController extends Controller
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

    public function index(Request $request)
    {

    	return view('exports.export_details')->with('export_id', $request->export_id);
    }

    public function list(Request $request)
    {
    	return \DB::table('export_details')
                  ->join('items', 'export_details.item_id', '=', 'items.id')
                  ->select('export_details.*', 'items.name', 'items.size', 'items.color')
                  ->where('export_id', $request->export_id)
                  ->get();
    }

    public function insert(StoreExportDetail $request)
    {

    	$item = Item::firstOrCreate([
    		'name' => $request->name,
    		'size' => $request->size,
    		'color' => $request->color,
    	]);

    	$export = Export::findOrFail($request->export_id);


    	ExportDetail::create([

    		'export_id' => $export->id,
    		'item_id' => $item->id,
            'quantity' => $request->quantity,
            'original_price' => $request->original_price,
            'unit_price' => $request->unit_price,
            'discount' => $request->discount,
            'total' => $request->total,

    	]);

    	return ezReturnSuccessMessage('Export item inserted successfully!');
    }

    public function update(StoreExportDetail $request)
    {
    	$item = Item::firstOrCreate([
    		'name' => $request->name,
    		'size' => $request->size,
    		'color' => $request->color,
    	]);

    	$exportDetail = ExportDetail::findOrFail($request->id);

    	$exportDetail->item_id = $item->id;
        $exportDetail->quantity = $request->quantity;
        $exportDetail->unit_price = $request->unit_price;
        $exportDetail->discount = $request->discount;
        $exportDetail->total = $request->total;

    	$exportDetail->save();
    	return ezReturnSuccessMessage('Export item updated successfully!');
    }

    public function destroy(Request $request)
    {
    	$exportDetail = ExportDetail::findOrFail($request->id);
    	$exportDetail->delete();
    	return ezReturnSuccessMessage('Export item deleted successfully!');
    }


}
