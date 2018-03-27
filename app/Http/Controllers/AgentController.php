<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agent;

class AgentController extends Controller
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
    	return view('agents.index');
    }

    public function list()
    {
    	return Agent::all();
    }

    public function listAgentNames()
    {
        return Agent::select('name')->get();
    }

    public function insert(Request $request)
    {

    	Agent::create(['name' => $request->name,
    				   'location' => $request->location,
    				   'contact_phone' => $request->contact_phone]);

    	return ezReturnSuccessMessage('Agent inserted successfully!');
    }

    public function update(Request $request)
    {
    	$agent = Agent::findOrFail($request->id);
    	$agent->fill($request->all());

    	$agent->save();
    	return ezReturnSuccessMessage('Agent updated successfully!');
    }

    public function destroy(Request $request)
    {
    	$agent = Agent::findOrFail($request->id);
    	$agent->delete();
    	return ezReturnSuccessMessage('Agent deleted successfully!');
    }
}
