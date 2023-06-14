<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\BookResource;
use App\Http\Requests\Books\StoreRequest;
use App\Http\Requests\Books\UpdateRequest;
use App\Models\BookHistory;

/**
 * Book controller
 * @author Putra <putrarohayzad>
 */
class BookController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::whereUserId(request()->user()->id)->latest()->get();
        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Books\StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $book = new Book();
        $book->fill($request->validated());
        $book->user_id = auth()->user()->id;
        $book->save();

        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Books\UpdateRequest $request
     * @param  \App\Models\Book $book
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Book $book,)
    {
        $book->update($request->validated());
        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return new BookResource($book);
    }

    /**
     * Update the status and page count , insert into book history for tracking resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book $book
     * @return \Illuminate\Http\Response
     */
    public function statusUpdate(Request $request, Book $book)
    {
        $request->validate([
            'status' => ['required'],
            'page_count' => ['required'],
        ]);

        return DB::transaction(function () use ($book, $request){
            $book->status = $request->status;
            $book->page_count = $request->page_count;
            $book->save();

            $bookHistory = new BookHistory();
            $bookHistory->book_id = $book->id;
            $bookHistory->page_count = $request->page_count;
            $bookHistory->save();

            return new BookResource($book);
        });

        
    }
}
