<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index() {
        $posts = Post::with(['user'])->paginate(10);
        return view('homepage', compact('posts'));
    }
}
