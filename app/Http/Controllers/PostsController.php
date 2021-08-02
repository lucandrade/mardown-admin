<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

final class PostsController extends Controller
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
}
