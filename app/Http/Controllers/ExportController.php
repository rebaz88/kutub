<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Export;
use App\Agent;
use App\Http\Requests\Exports\StoreExport;

class ExportController extends DistributerAgentBaseController
{
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
    	return view('exports.index');
    }

    public function list()
    {
        return Export::all();
    }

    public function insert(StoreExport $request)
    {
    	$agent = Agent::where('name', $request->agent_name)->firstOrFail();

    	$export = Export::create([
    		'agent_id' => $agent->id,
            'date' => toMysqlDate($request->date),
            'note' => $request->note,
    	]);

    	return ezReturnSuccessMessage('Export inserted successfully!', $export->id);
    }

    public function update(Request $request)
    {
    	$export = Export::findOrFail($request->id);
    	$agent = Agent::findOrFail($request->agent_id);

        $export->agent_id = $request->agent_id;
        $export->date = toMysqlDate($request->date);
        $export->note = $request->note;

    	$export->save();
    	return ezReturnSuccessMessage('Export updated successfully!', $export->id);
    }

    public function destroy(Request $request)
    {
    	$export = Export::findOrFail($request->id);
    	$export->delete();
    	return ezReturnSuccessMessage('Export deleted successfully!');
    }


}
