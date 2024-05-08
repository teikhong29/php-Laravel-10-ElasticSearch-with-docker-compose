<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\PostRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{
    const key = 'post_data';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Redis String
        $posts = Redis::get(self::key);
        if(!$posts)
        {
            $posts = Post::all();
            if($posts->isNotEmpty())
            {
                Redis::set(self::key, json_encode($posts));
            }
        }
        else
        {
            $posts = json_decode($posts);
        }
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
    public function store(PostRequest $request)
    {
        $post = Post::create($request->validated());

        // Redis String
        $existingData = json_decode(Redis::get(self::key), true) ?? [];
        $existingData[] = $post;
        Redis::set(self::key, json_encode($existingData));

        return redirect()->route('posts.index')->with('message', 'Post Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
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
    public function update(PostRequest $request, Post $post)
    {
        $post->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        // Redis String
        $existingData = json_decode(Redis::get(self::key), true);
        if ($existingData) {
            foreach ($existingData as &$data) {
                if ($data['id'] == $post->id) {
                    $data['title'] = $post['title'];
                    $data['content'] = $post['content'];
                    break;
                }
            }
            Redis::set(self::key, json_encode($existingData));
        }

        return redirect()->route('posts.index')->with('message', 'Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        // Redis String
        $existingData = json_decode(Redis::get(self::key), true);
        if ($existingData) {
            $existingData = array_values(array_filter($existingData, function ($data) use ($post) {
                return $data['id'] != $post->id;
            }));
            Redis::set(self::key, json_encode($existingData));
        }

        return redirect()->route('posts.index')->with('message', 'Post Deleted Successfully');
    }
}
