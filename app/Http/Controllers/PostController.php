<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->simplePaginate(5);

        return view('post.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('post.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request, Cloudinary $cloudinary)
    {
        $data = $request->validated();

        $image = $data['image'];
        unset($data['image']);

        $data['user_id'] = Auth::id();
        $baseSlug = Str::slug($data['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $data['slug'] = $slug;

        $imagePath = $image->getRealPath();
        $upload = $cloudinary->uploadApi()->upload($imagePath, [
            'folder' => 'posts',
        ]);

        $data['image'] = $cloudinary->image($upload['public_id'])->quality('auto')->format('auto')->toUrl();

        Post::create($data);
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Post $post)
    {
        return view('post.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::get();
        return view('post.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post, Cloudinary $cloudinary)
    {
        $data = $request->all();
        $user = Auth::user();
        if ($user->id !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

            unset($data['image']);
            $imagePath = $image->getRealPath();
            $upload = $cloudinary->uploadApi()->upload($imagePath, [
                'folder' => 'posts',
                'public_id' => Str::slug($imageName)
            ]);

            $data['image'] = $cloudinary->image($upload['public_id'])->quality('auto')->format('auto')->toUrl();
        }

        if ($request->title !== $post->title) {
            $baseSlug = Str::slug($data['title']);
            $slug = $baseSlug;
            $counter = 1;
            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $data['slug'] = $slug;
        } else {
            unset($data['slug']);
        }
        $post->update($data);

        return redirect()->route('post.show', ['user' => $user->username, 'post' => $post->slug]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('dashboard');
    }

    public function categorize(Category $category)
    {
        $posts = $category->posts()->latest()->simplePaginate(5);
        return view('post.index', ['posts' => $posts]);
    }
}
