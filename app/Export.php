<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Agent;
use App\ExportDetail;

class Export extends Model
{
    protected $fillable = [

    	'agent_id', 'date', 'note'

    ];

     protected $appends = [

        'agent_name', 'total'

    ];

    public function agent()
    {
    	return $this->belongsTo('App\Agent');
    }

    public function getAgentNameAttribute()
    {
        return Agent::find($this->agent_id)->select('name')->first()->name;
    }

    public function getTotalAttribute()
    {
        return ExportDetail::selectRaw('SUM(total) as total')->where('export_id', $this->id)->first()->total;
    }

    public function getDateAttribute($value)
    {
        return toDMYDate($value);
    }

    public function exportDetails()
  	{
    	return $this->hasMany('App\ExportDetail');
  	}
}
