<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Import;
use App\ImportDetail;
use App\Item;
use App\Http\Requests\Imports\StoreImportDetail;

class ImportDetailController extends Controller
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

    	return view('imports.import_details')->with('import_id', $request->import_id);
    }

    public function list(Request $request)
    {
    	return \DB::table('import_details')
    			  ->join('items', 'import_details.item_id', '=', 'items.id')
				  ->select('import_details.*', 'items.name', 'items.size', 'items.color')
				  ->where('import_id', $request->import_id)
				  ->get();
    }

    public function insert(StoreImportDetail $request)
    {

    	$item = Item::firstOrCreate([
    		'name' => $request->name,
    		'size' => $request->size,
    		'color' => $request->color,
    	]);

    	$import = Import::findOrFail($request->import_id);


    	ImportDetail::create([

    		'import_id' => $import->id,
    		'item_id' => $item->id,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'discount' => $request->discount,
            'total' => $request->total,

    	]);

    	return ezReturnSuccessMessage('Import item inserted successfully!');
    }

    public function update(StoreImportDetail $request)
    {
    	$item = Item::firstOrCreate([
    		'name' => $request->name,
    		'size' => $request->size,
    		'color' => $request->color,
    	]);

    	$importDetail = ImportDetail::findOrFail($request->id);

    	$importDetail->item_id = $item->id;
        $importDetail->quantity = $request->quantity;
        $importDetail->unit_price = $request->unit_price;
        $importDetail->discount = $request->discount;
        $importDetail->total = $request->total;

    	$importDetail->save();
    	return ezReturnSuccessMessage('Import item updated successfully!');
    }

    public function destroy(Request $request)
    {
    	$importDetail = ImportDetail::findOrFail($request->id);
    	$importDetail->delete();
    	return ezReturnSuccessMessage('Import item deleted successfully!');
    }


}
