<?php

namespace App\Http\Controllers;


use App\Book;
use App\Category;
use App\Author;
use App\RandomFile;
use Illuminate\Http\Request;

use App\Http\Requests\Books\StoreBook;
use App\Http\Requests\Books\UpdateBook;

use App\Helpers\EasyuiPagination;

class BookController extends Controller
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
    	return view('books.index');
    }

    public function list(Request $request)
    {
      $query = \DB::table('books')
                  ->join('categories', 'categories.id', 'books.category_id')
                  ->join('authors', 'authors.id', 'books.author_id')
                  ->select('books.id', 'books.title', 'categories.name as category', 'authors.name as author');

      collect(($request->has('filterRules')) ? json_decode($request->filterRules) : [])->each(function ($filterRule, $key) use ($query){
          $query->where($filterRule->field, 'like', '%'. $filterRule->value .'%');
      });

      $data = EasyuiPagination::paginageData($request, $query);
      $data['rows'] = collect($data['rows'])->map(function($row, $key) {
        $book = Book::find($row->id);
        $attachments = $book->getAttachments();

        $row->book_image = $attachments->where('mime_type', '<>', 'application/pdf')->first();
        $row->book_file = $attachments->where('mime_type', '=', 'application/pdf')->first();

        return $row;
      });
    	return $data;
    }

    public function listCategories()
    {
      return Category::get(['name']);
    }

    public function listAuthors()
    {
      return Author::get(['name']);
    }


    public function showInsert(Request $request)
    {
      return view('books.insert_book');
    }

    /**
     * Create a new book instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Book
     */
    protected function insert(StoreBook $request)
    {
        $book = Book::create($request->all());

        $category = Category::firstOrCreate(['name' => $request->category]);
        $book->category()->associate($category)->save();

        $author = Author::firstOrCreate(['name' => $request->author]);
        $book->author()->associate($author)->save();

        $this->saveAttachment($request, $book, 'book_image');
        $this->saveAttachment($request, $book, 'book_file');

        return ezReturnSuccessMessage('Book saved successfully!');
    }

    public function showUpdate(Request $request)
    {
      $book = Book::findOrFail($request->id);
      // return $book;
      return view('books.update_book')->with('book', $book);
    }

    public function update(UpdateBook $request)
    {
    	$book = Book::findOrFail($request->id);
      $book->update($request->all());

      $category = Category::firstOrCreate(['name' => $request->category]);
      $book->category()->associate($category)->save();

      $author = Author::firstOrCreate(['name' => $request->author]);
      $book->author()->associate($author)->save();

      $this->saveAttachment($request, $book, 'book_image');
      $this->saveAttachment($request, $book, 'book_file');

      return ezReturnSuccessMessage('Book updated successfully!');
    }

    public function destroy(Request $request)
    {

      $book = Book::findOrFail($request->id);

      $book->clearMediaCollection();


      $book->delete();

      return ezReturnSuccessMessage('Book removed successfully!');

    }

    public function destroyMedia(Request $request)
    {

    	$book = Book::findOrFail($request->book_id);

      $media = $book->getMedia()->where('id', $request->media_id)->first();

      if($media)
    	 $media->delete();

    	return ezReturnSuccessMessage('Media removed successfully!');

    }

}
