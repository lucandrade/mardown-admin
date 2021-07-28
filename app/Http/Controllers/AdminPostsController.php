<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class AdminPostsController extends Controller
{
    public function get(int $id): Response
    {
        $post = Post::find($id);

        return response(view('post', [
            'post' => $post,
        ]), $post ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    public function update(int $id, Request $request): Response
    {
        /** @var Post $post */
        $post = Post::find($id);

        if (!$post) {
            return redirect('/admin')->withErrors(['Post not found']);
        }

        $post->updateContent(
            strval($request->input('markdown_content')),
            strval($request->input('html_content'))
        );
        $post->save();

        return redirect("/admin/{$id}")->with('success', 'Post created');
    }
}
