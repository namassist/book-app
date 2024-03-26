<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        try {
            $this->validate($request,[
                'title' => 'required|string|max:10',
                'description' => 'required|string',
                'author' => 'required|string|max:10',
            ]);
            $books = new Book();
        } catch (\Exception $e) {
            dd(get_class($e));
        }

        $books->title = $request->input('title');
        $books->author = $request->input('author');
        $books->description = $request->input('description');

        $books->save();
        return response()->json($books, 201);
    }

    public function show($id)
    {
        try {
            $books = Book::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Book not found'
                ]
            ], 404);
        }
        return $books;
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request,[
                'title' => 'required|string|max:100',
                'author' => 'required|string|max:100',
                'description' => 'required|string',
            ]);

            $books = Book::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Book not found'
                ]
            ], 404);
        }

        $books->title = $request->input('title');
        $books->author = $request->input('author');
        $books->description = $request->input('description');

        $books->save();
        return $books;
    }

    public function destroy($id)
    {
        try {
            $books = Book::findOrFail($id);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Book not found'
                ]
            ], 404);
        }

        $books->delete();
        return response()->json(null, 204);
    }

}
