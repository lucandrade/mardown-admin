<?php declare(strict_types=1);

namespace Tests\Acceptance;

use App\Models\Post;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

final class PostsTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_list_posts()
    {
        $user = $this->login();
        Post::make('First markdown post', 'First post', $user)->save();
        Post::make('Second markdown post', 'Second post', $user)->save();
        $response = $this->get('/admin');
        $response
            ->assertSeeInOrder(['First post', 'Second post']);
    }

    /**
     * @test
     */
    public function it_can_show_a_post()
    {
        $user = $this->login();

        $post = Post::make('First markdown post', 'First post', $user);
        $post->save();

        $response = $this->get("/admin/{$post->id}");
        $response
            ->assertSeeInOrder(['First markdown post', 'First post']);
    }

    /**
     * @test
     */
    public function it_returns_404_for_not_found_post()
    {
        $this->login();
        $response = $this->get("/admin/1");
        $response
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

    private function login(): User
    {
        $user = User::make('username', 'password');
        $user->save();

        $this->post('/login', [
            'username' => 'username',
            'password' => 'password',
        ]);

        return $user;
    }
}
