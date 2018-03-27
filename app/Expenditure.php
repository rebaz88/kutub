<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Expenditure extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $guarded = [];
    protected $appends = ['attachment'];


    public function getDateAttribute($value)
    {
        return toDMYDate($value);
    }

    public function getAttachmentAttribute()
    {
    	$mediaItems = $this->getMedia();

    	if(sizeof($mediaItems) > 0) {
    		return $mediaItems[0]->getUrl();
    	}
    }

    public static $withoutAppends = false;

	protected function getArrayableAppends()
	{
	    if(self::$withoutAppends){
	        return [];
	    }
	    return parent::getArrayableAppends();
	}

}
