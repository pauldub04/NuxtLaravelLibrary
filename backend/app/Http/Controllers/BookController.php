<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{
    public function all() {
        return Book::all();
    }

    public function add(Request $request) {
        $book = new Book;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->availability = true;

        $book->save();

        return back();
    }


    public function delete($id) {
        $book = Book::findOrFail($id);
        $book->delete();
        return back();
    }

    public function changeAvailability($id) {
        $book = Book::find($id);
        $book->availability = !$book->availability;
        $book->save();
        return back();
    }
}
