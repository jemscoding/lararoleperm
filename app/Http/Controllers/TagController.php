<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'tag_name' => 'required|max:255|unique:tags',
            'tag_desc' => 'max:255'
        ]);

        //generates the updated slug using the Str class
        $slug = Str::slug($validatedData['tag_name']);

        //adding the new slug to the validated data value
        $validatedData['tag_slug'] = $slug;

        // dd($validatedData); // Debugging line

        $tag = Tag::create($validatedData);

        return redirect()->route('tags.index')
            ->with('success', 'Tag created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        $tag = Tag::find($tag->id);
        return view('tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $validatedData = $request->validate([
            'tag_name' => ['required','max:255',
            Rule::unique('tags')->ignore($tag->id),
        ],  'tag_desc' => 'max:255'
        ]);

        //generates the updated slug using the Str class
        $slug = Str::slug($validatedData['tag_name']);

        //adding the new slug to the validated data value
        $validatedData['tag_slug'] = $slug;

        $tag->update($validatedData);

        return redirect()->route('tags.index')
            ->with('success', 'Tag created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag = Tag::find($tag->id);
        $tag->delete();
        return redirect()->route('tags.index')
            ->with('success', 'Tag deleted successfully.');
    }
}
