<?php declare(strict_types=1);

namespace Tests\Acceptance;

use App\Models\Post;
use App\Models\User;

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
