<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request)
    {
        // definiskan rule untuk validator
        $validator = Validator::make($request->all(), [
            'image'     => 'required|image|mimes:png,jpg, jpeg, gif, svg|max:2048',
            'title'     => 'required',
            'content'   => 'required'
        ]);

        // Cek dulu jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // upload gambar
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        // setelah upload image buat post untuk data
        $post = Post::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content,
        ]);

        // return respon hasil
        return new PostResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }
}
