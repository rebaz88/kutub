<?php

namespace App\Http\Controllers;


use App\Video;
use App\Category;
use App\Author;
// use App\VideoImage;
use Illuminate\Http\Request;

use App\Http\Requests\Videos\StoreVideo;
use App\Http\Requests\Videos\UpdateVideo;

use App\Helpers\EasyuiPagination;

class VideoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); // allow creating through admin only
    }

    public function index()
    {
    	return view('videos.index');
    }

    public function list(Request $request)
    {
      $query = \DB::table('videos')
                  ->join('categories', 'categories.id', 'videos.category_id')
                  ->select('videos.id', 'videos.title', 'categories.name as category');

      collect(($request->has('filterRules')) ? json_decode($request->filterRules) : [])->each(function ($filterRule, $key) use ($query){
          $query->where($filterRule->field, 'like', '%'. $filterRule->value .'%');
      });

      $data = EasyuiPagination::paginageData($request, $query);
      $data['rows'] = collect($data['rows'])->map(function($row, $key) {
        $video = Video::find($row->id);
        $attachments = $video->getAttachments();
        // return $attachments;
        $row->video_file = $attachments->first();

        return $row;
      });
    	return $data;
    }

    public function listCategories()
    {
      return Category::get(['name']);
    }

    public function showInsert(Request $request)
    {
      return view('videos.insert_video');
    }

    /**
     * Create a new video instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Video
     */
    protected function insert(StoreVideo $request)
    {
        $video = Video::create($request->all());

        $category = Category::firstOrCreate(['name' => $request->category]);
        $video->category()->associate($category)->save();

        $this->saveAttachment($request, $video, 'video_file');

        return ezReturnSuccessMessage('Video saved successfully!');
    }

    public function showUpdate(Request $request)
    {
      $video = Video::findOrFail($request->id);
      return view('videos.update_video')->with('video', $video);
    }

    public function update(UpdateVideo $request)
    {
    	$video = Video::findOrFail($request->id);
      $video->update($request->all());

      $category = Category::firstOrCreate(['name' => $request->category]);
      $video->category()->associate($category)->save();

      $this->saveAttachment($request, $video, 'video_file');

      return ezReturnSuccessMessage('Video updated successfully!');
    }

    public function destroy(Request $request)
    {

      $video = Video::findOrFail($request->id);

      $video->clearMediaCollection();


      $video->delete();

      return ezReturnSuccessMessage('Video removed successfully!');

    }

    public function destroyMedia(Request $request)
    {

    	$video = Video::findOrFail($request->video_id);

      $media = $book->getMedia()->where('id', $request->media_id)->first();

      if($media)
    	 $media->delete();

    	return ezReturnSuccessMessage('Media removed successfully!');

    }


}
