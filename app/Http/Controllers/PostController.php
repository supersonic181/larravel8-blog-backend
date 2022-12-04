<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController
{
    public function getAllPost()
    {
        return Post::all();
    }

    public function getPostById(Post $post)
    {
        return $post;
    }

    public function deletePostById(Post $post)
    {
        $post->delete();
        return response()->json("Deleted Successfully");
    }

    public function createPost(Request $request)
    {
        $id = Auth::id();
        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'post_type' => ['required'],
            'thumbnail' => ['image'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'tags' => ['required'],
            'tags.*' => ['exists:tags,id']
        ]);


        if ($request->file('thumbnail') != null) {
            // $isFileUploaded = Storage::disk('local')->put($request->file('thumbnail')->getClientOriginalName(), $request->file('thumbnail')->get());

            $path = $request->file('thumbnail')->store('/images');
        }

        $tags_array = json_decode($request->tags);

        // dd($path);
        $post = Post::create([
            'author_id' => $id,
            'title' => $request->title,
            'body' => $request->body,
            'post_type' => $request->post_type,
            'thumbnail' => $path,
            'category_id' => $request->category_id
        ]);
        $post->tags()->attach($tags_array);
        return $post->fresh();
    }

    public function createVideoPost(Request $request)
    {
        $id = Auth::id();
        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required', 'file', 'mimes:mp4'],
            'post_type' => ['required'],
            'thumbnail' => ['image'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'tags' => ['required'],
            'tags.*' => ['exists:tags,id']
        ]);

        $tags_array = json_decode($request->tags);

        if ($request->file('thumbnail') != null) {
            $imagePath = $request->file('thumbnail')->store('/images');
        }

        if ($request->file('body') != null) {

            $videoPath = $request->file('body')->store('/video');
            // dd($videoPath);
        }

        // dd($path);
        $post = Post::create([
            'author_id' => $id,
            'title' => $request->title,
            'body' => $videoPath,
            'post_type' => $request->post_type,
            'thumbnail' => $imagePath,
            'category_id' => $request->category_id
        ]);
        $post->tags()->attach($tags_array);
        return $post->fresh();
    }


    public function updatePost(Post $post, Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'post_type' => ['required'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'tags' => ['required'],
            'tags.*' => ['exists:tags,id']
        ]);

        $post->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'post_type' => $validated['post_type'],
            'category_id' => $validated['category_id']
        ]);
        $post->tags()->sync($validated['tags']);
        return $post->fresh();
    }
}
