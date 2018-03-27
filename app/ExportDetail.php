<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExportDetail extends Model
{
    protected $fillable = [

		'item_id','export_id','quantity', 'original_price', 'unit_price','discount','total',

    ];

    public function item()
  	{
    	return $this->belongsTo('App\Item');
  	}

  	public function export()
  	{
    	return $this->belongsTo('App\Export');
  	}
}
