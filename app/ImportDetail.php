<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportDetail extends Model
{
    protected $fillable = [

		'item_id','import_id','quantity','unit_price','discount','total',

    ];

    public function item()
  	{
    	return $this->belongsTo('App\Item');
  	}

  	public function import()
  	{
    	return $this->belongsTo('App\Import');
  	}
}
