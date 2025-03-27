<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    // public function __construct()
    // {
    //     // Apply policies to methods
    //     $this->authorizeResource(Post::class, 'post');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('author')
            ->published()
            ->latest('published_at')
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'is_published' => $request->has('is_published') ? 1 : 0
        ]);

         // Sanitize and validate input
         $validatedData = $request->validate([
            'title' => 'required|max:255|unique:posts,title',
            'content' => 'required|max:65535',
            'ft_image' => 'nullable|max:2048|image|mimes:jpeg,png,jpg',
            'is_published' => 'boolean'

        ]);

        // Sanitize content
        $sanitizedContent = strip_tags($validatedData['content'], '<p><a><strong><em><h1><h2><h3><h4><h5><h6><ul><ol><li>');


        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('ft_image')) {
            $image = $request->file('ft_image');
            $imageName = Str::slug($validatedData['title']) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('posts', $imageName, 'public');
        }

        // Create post
        $post = new Post([
            'title' => Str::headline($validatedData['title']),
            'content' => $sanitizedContent,
            'ft_image' => $imagePath,
            'user_id' => Auth::id(),
            'is_published' => $validatedData['is_published'] ?? false
        ]);

        // Set published at if published
        if ($post->is_published) {
            $post->published_at = now()->toDateString();
        }

        $post->save();

        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Only show published posts or posts sang author
        if (!$post->is_published && $post->user_id !== Auth::id()) {
            abort(403);
        }

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {

         return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->merge([
            'is_published' => $request->has('is_published') ? 1 : 0
        ]);


        // Validate input
        $validatedData = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('posts', 'title')->ignore($post->id)
            ],
            'content' => [
                'required',
                'string',
                'min:10'
            ],
            'ft_image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048'
            ],
            'is_published' => 'boolean'
        ]);

        // Sanitize content
        $sanitizedContent = strip_tags($validatedData['content'], '<p><a><strong><em><h1><h2><h3><h4><h5><h6><ul><ol><li>');

        // Handle file upload
        if ($request->hasFile('ft_image')) {
            // Delete old image if exists
            if ($post->ft_image) {
                \Storage::disk('public')->delete($post->ft_image);
            }

            $image = $request->file('ft_image');
            $imageName = Str::slug($validatedData['title']) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('posts', $imageName, 'public');
        } else {
            $imagePath = $post->ft_image;
        }

        // Update post
        $post->fill([
            'title' => Str::headline($validatedData['title']),
            'content' => $sanitizedContent,
            'ft_image' => $imagePath,
            'is_published' => $validatedData['is_published'] ?? false
        ]);

        // Set or update published at
        if ($post->is_published && !$post->published_at) {
            $post->published_at = now()->toDateString();
        }

        $post->save();

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Ensure only the author or an admin can delete
        $this->authorize('delete', $post);

        // Delete featured image if exists
        if ($post->ft_image) {
            \Storage::disk('public')->delete($post->ft_image);
        }

        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully.');
    }


    public function publish(Post $post)
    {
        // $this->authorize('publish', $post);

        $post->update(['published_at' => now()]);

        return redirect()->route('posts.show', $post);
    }
}
