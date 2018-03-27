<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\User;

use App\Helpers\EasyuiPagination;

class ActivityController extends Controller
{
    public function index()
    {
    	return view('activities.index');
    }

    public function list(Request $request)
    {
    	$query = \DB::table('activity_log')
    				->join('users', 'activity_log.causer_id', 'users.id')
    				->leftJoin('agent_user', 'users.id', 'agent_user.user_id')
    				->leftJoin('agents', 'agents.id', 'agent_user.agent_id')
    				->select('activity_log.*', 'users.name as users.name', 'agents.name as agents.name')
    				->orderBy('activity_log.created_at', 'desc');

    	if($request->has('filterRules')) {

        $filterRules = json_decode($request->filterRules);

        foreach ($filterRules as $filterRule) {

          if($filterRule->field == 'filter_by_date')
          {
            $query->whereBetween('activity_log.created_at', [toMysqlDate($filterRule->filter_from),toMysqlDate($filterRule->filter_to)]);
          }
          elseif($filterRule->field == 'description')
          {
            $query->where('activity_log.description', 'like', '%'. $filterRule->value .'%');
          }
          else
          {
            $query->where($filterRule->field, 'like', '%'. $filterRule->value .'%');
          }
        }
      }

    	$result = EasyuiPagination::paginageData($request, $query);

    	foreach ($result['rows'] as $activity) {

    		$properties = collect(json_decode($activity->properties));
    		$activity->properties = ($properties->count() > 0)? $properties : null;
    		$activity->created_at = toDMYTime($activity->created_at);
    	}

    	return $result;

    }

    public function listModelActivityNames()
    {
    	$modelActivityNames = Activity::distinct('properties')->get(['properties']);

    	$modelActivities = [];
    	foreach ($modelActivityNames as $modelActivityName) {
    		$properties = collect(json_decode($modelActivityName->properties));
    		$modelActivities[] = $properties;
    	}
    	return $modelActivities;
    }

}
