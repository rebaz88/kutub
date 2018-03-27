<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Import;
use App\Http\Requests\Imports\StoreImport;

class ImportController extends DistributerAgentBaseController
{

    protected $current_user_agent_id;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
    	return view('imports.index');
    }

    public function list(Request $request)
    {
    	return Import::where('agent_id', $request->current_user_agent_id)->get();
    }

    public function insert(StoreImport $request)
    {
    	$import = Import::create([
            'agent_id' => $request->current_user_agent_id,
            'invoice' => $request->invoice,
            'date' => toMysqlDate($request->date),
            'type' => $request->type,
            'port' => $request->port,
            'container' => $request->container,
            'vendor' => $request->vendor,
            'note' => $request->note,
    	]);

    	return ezReturnSuccessMessage('Import inserted successfully!', $import->id);
    }

    public function update(Request $request)
    {
    	$import = Import::findOrFail($request->id);

        $import->agent_id = $request->current_user_agent_id;
    	$import->invoice = $request->invoice;
        $import->date = toMysqlDate($request->date);
        $import->type = $request->type;
        $import->port = $request->port;
        $import->container = $request->container;
        $import->vendor = $request->vendor;
        $import->note = $request->note;

    	$import->save();
    	return ezReturnSuccessMessage('Import updated successfully!', $import->id);
    }

    public function destroy(Request $request)
    {
    	$import = Import::where('id', $request->id)
                        ->where('agent_id', $current_user_agent_id)
                        ->firstOrFail();

    	$import->delete();

    	return ezReturnSuccessMessage('Import deleted successfully!');
    }


}
