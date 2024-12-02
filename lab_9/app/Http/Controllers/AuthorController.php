<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        return response()->json(Author::all());
    }

    public function show($id)
    {
        $author = Author::findOrFail($id);
        return response()->json($author);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'biography' => 'nullable|string',
        ]);

        $author = Author::create($validated);
        return response()->json($author, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'biography' => 'nullable|string',
        ]);

        $author = Author::findOrFail($id);
        $author->update($validated);
        return response()->json($author);
    }

    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();
        return response()->json(null, 204);
    }
}
