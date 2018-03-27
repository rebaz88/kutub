<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Item;
use App\Http\Requests\Items\StoreItem;
use App\Http\Requests\Items\UpdateItem;

class ItemController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	return view('items.index');
    }

    public function list()
    {
    	return Item::all();
    }

    public function listItemNames(Request $request, $fieldName)
    {
        return Item::where($fieldName, 'like', '%' . $request->q . '%')->distinct($fieldName)->limit(10)->get([$fieldName]);
    }

    public function insert(StoreItem $request)
    {
    	Item::create([
    		'name' => $request->name,
    		'size' => $request->size,
    		'color' => $request->color,
    	]);

    	return ezReturnSuccessMessage('Item inserted successfully!');
    }

    public function update(UpdateItem $request)
    {
    	$item = Item::findOrFail($request->id);
    	$item->name = $request->name;
		$item->size = $request->size;
		$item->color = $request->color;

    	$item->save();
    	return ezReturnSuccessMessage('Item updated successfully!');
    }


    public function destroy(Request $request)
    {
    	$item = Item::findOrFail($request->id);
    	$item->delete();
    	return ezReturnSuccessMessage('Item deleted successfully!');
    }
}
