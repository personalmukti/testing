<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    // Index
    public function index()
    {
        // get posts
        $posts = Post::latest()->paginate(5);

        // mengambil collection sebagai resources
        return new PostResource(true, 'List Data Posts', $posts);
    }
}
