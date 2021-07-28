<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;

final class AdminController extends Controller
{
    public function index()
    {
        return view('posts', [
            'posts' => Post::all(),
        ]);
    }
}
