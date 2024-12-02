<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return response()->json(Book::all());
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year' => 'required|integer|min:1500|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'required|exists:genres,id',
        ]);

        $book = Book::create($validated);
        return response()->json($book, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'year' => 'integer|min:1500|max:' . date('Y'),
            'price' => 'numeric|min:0',
            'author_id' => 'exists:authors,id',
            'genre_id' => 'exists:genres,id',
        ]);

        $book = Book::findOrFail($id);
        $book->update($validated);
        return response()->json($book);
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->json(null, 204);
    }
}

