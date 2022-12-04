<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TagController 
{
    public function createTag(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'unique:tags,name']
        ]);

        $slug = Str::of($validated['name'])->slug('-');

        return Tag::create([
            "name" => $validated['name'],
            "slug" => $slug
        ]);
    }

    public function updateTag(Tag $tag, Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', Rule::unique('tags')->ignore($tag->id)],
        ]);

        $slug = Str::of($validated['name'])->slug('-');

        $tag->update([
            "name" => $validated['name'],
            "slug" => $slug
        ]);

        return $tag;
    }

    public function deleteTag(Tag $tag)
    {
        $tag->delete();
        return response()->json("Successfully Deleted");
    }

    public function getTag()
    {
        return Tag::all();
    }
}