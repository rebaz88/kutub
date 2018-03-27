<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Code extends Model implements HasMedia
{

    use HasMediaTrait;

	// The name to be used by activity logger when logging using activity on this model
    const MODEL_ACTIVITY_NAME = 'Codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'category', 'description',
    ];


    // public function registerMediaConversions(Media $media = null)
    // {
    //     $this->addMediaConversion('thumb')
    //           ->width(368)
    //           ->height(232)
    //           ->sharpen(10);

    //     $this->addMediaConversion('medium')
    //           ->width(736)
    //           ->height(464)
    //           ->sharpen(20);

    //     $this->addMediaConversion('large')
    //           ->width(1072)
    //           ->height(696)
    //           ->sharpen(30);

    // }
}

