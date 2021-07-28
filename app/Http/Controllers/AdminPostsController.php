<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Symfony\Component\HttpFoundation\Response;

final class AdminPostsController extends Controller
{
    public function get(int $id)
    {
        $post = Post::find($id);

        return response(view('post', [
            'post' => $post,
        ]), $post ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }
}
