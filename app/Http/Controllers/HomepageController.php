<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index() {
        $posts = Post::with(['user'])->paginate(10);
        $activeUsers = User::select('name')->withCount(['posts' => function (Builder $query) {
            $query->whereDate('created_at', '>=', Carbon::now()->subDays(7));
        }])->orderBy('posts_count', 'desc')->take(3)->get();
        return view('homepage', compact('posts','activeUsers'));
    }
}
