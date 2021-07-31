<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

final class AdminPostsController extends Controller
{
    /** @var LoggerInterface */
    private $logger;

    /** @var Post */
    private $repository;

    public function __construct(LoggerInterface $logger, Post $repository)
    {
        $this->logger = $logger;
        $this->repository = $repository;
    }

    public function index(): Response
    {
        try {
            $posts = $this->repository->all();

            return response(view('posts', [
                'posts' => $posts,
            ]));
        } catch (\Throwable $e) {
            $this->logger->error("Error listing posts", [
                "e" => $e->getMessage(),
                "ex" => $e,
            ]);
            return response(view('posts', [
                'posts' => [],
            ]));
        }
    }

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

        $data = $request->validate([
            'markdown_content' => 'required',
            'html_content' => 'required',
        ]);

        if (!$data) {
            return redirect("/admin/{$id}");
        }

        $post->updateContent(
            strval($request->input('markdown_content')),
            strval($request->input('html_content'))
        );
        $post->save();

        return redirect("/admin/{$id}")->with('success', 'Post created');
    }

    public function create(Request $request): Response
    {
        $data = $request->validate([
            'markdown_content' => 'required',
            'html_content' => 'required',
        ]);

        if (!$data) {
            return redirect("/admin/create");
        }

        /** @var User $user */
        $user = Auth::user();
        $post = Post::make(
            $request->input('markdown_content'),
            $request->input('html_content'),
            $user
        );
        $post->save();

        return redirect("/admin/{$post->id}")->with('success', 'Post created');
    }
}
