<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Book extends Model implements HasMedia
{

    use HasMediaTrait;

	// The name to be used by activity logger when logging using activity on this model
    const MODEL_ACTIVITY_NAME = 'Books';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description'];

    public function author()
    {
      return $this->belongsTo('App\Author');
    }

    public function category()
    {
      return $this->belongsTo('App\Category');
    }

    public function getAttachments()
    {
      $mediaItems = $this->getMedia();

      return $mediaItems->map(function($mediaItem, $key) {
        return ['url' => $mediaItem->getUrl(),
                'mime_type' => $mediaItem->mime_type];
      });

    }
}
