<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use App\Models\Book;

class BooksController extends Controller
{
    /**
     * GET /books
     * @return array
    */
    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'author' => 'required|string|max:255',
        ]);

        $books = new Book();

        $books->title = $request->input('title');
        $books->author = $request->input('author');
        $books->description = $request->input('description');

        $books->save();
        return response()->json($books, 201);
    }

    public function show($id)
    {
        $books = Book::find($id);
        return response()->json($books);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' => 'required|string|max:100',
            'author' => 'required|string|max:100',
            'description' => 'required|string',
        ]);

        $books = Book::find($id);

        $books->title = $request->input('title');
        $books->author = $request->input('author');
        $books->description = $request->input('description');

        $books->save();
        return response()->json($books);
    }

    public function destroy($id)
    {
        $books = Book::find($id);
        $books->delete();
        return response()->json("Books Deleted Successfully!");
    }

}
