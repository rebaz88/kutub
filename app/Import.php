<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ImportDetail;

class Import extends Model
{
    protected $fillable = [
    	'agent_id', 'invoice','date','type','port','container','vendor','note',
    ];

    protected $appends = [

        'total'

    ];

    public function getTotalAttribute()
    {
        return ImportDetail::selectRaw('SUM(total) as total')->where('import_id', $this->id)->first()->total;
    }

    public function getDateAttribute($value)
    {
        return toDMYDate($value);
    }

    public function importDetails()
  	{
    	return $this->hasMany('App\ImportDetail');
  	}

}
