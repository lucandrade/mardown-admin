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

            return response(view('admin.posts', [
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
        try {
            $post = $this->repository->find($id);

            return response(view('admin.post-form', [
                'post' => $post,
            ]), $post ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            $this->logger->error("Error fetching post", [
                "e" => $e->getMessage(),
                "ex" => $e,
            ]);

            return response(view('post', [
                'post' => [],
            ]), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(int $id, Request $request): Response
    {
        try {
            /** @var Post $post */
            $post = $this->repository->find($id);

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

            return redirect("/admin/{$id}")->with('success', 'Post saved');
        } catch (ValidationException $e) {
            return redirect('/admin')->withErrors($e->errors());
        } catch (\Throwable $e) {
            $this->logger->error("Error updating post", [
                "post" => $id,
                "e" => $e->getMessage(),
                "ex" => $e,
            ]);
            return redirect('/admin')->withErrors(["Error updating post"]);
        }
    }

    public function create(Request $request): Response
    {
        try {
            $data = $request->validate([
                'markdown_content' => 'required',
                'html_content' => 'required',
            ]);

            if (!$data) {
                return redirect("/admin/create");
            }

            /** @var User $user */
            $user = Auth::user();
            $post = $this->repository->make(
                $request->input('markdown_content'),
                $request->input('html_content'),
                $user
            );
            $post->save();

            return redirect("/admin/{$post->id}")->with('success', 'Post created');
        } catch (ValidationException $e) {
            return redirect('/admin/create')->withErrors($e->errors());
        } catch (\Throwable $e) {
            $this->logger->error("Error creating a post", [
                "e" => $e->getMessage(),
                "request" => $request,
                "ex" => $e,
            ]);

            return redirect("/admin")->with('error', 'Unknown error occurred');
        }
    }
}
