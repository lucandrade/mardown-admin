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

    /**
     * @test
     */
    public function it_can_update_a_post()
    {
        $user = $this->login();

        $post = Post::make('First markdown post', 'First post', $user);
        $post->save();

        $response = $this->post("/admin/{$post->id}", [
            'markdown_content' => 'Markdown changed',
            'html_content' => 'HTML changed',
        ]);
        $response
            ->assertRedirect("/admin/{$post->id}");
        $updatedPost = Post::find($post->id);

        $this->assertThat($updatedPost->markdown_content, $this->identicalTo('Markdown changed'));
        $this->assertThat($updatedPost->html_content, $this->identicalTo('HTML changed'));
    }

    /**
     * @test
     */
    public function it_redirects_to_admin_page_when_post_is_not_found()
    {
        $this->login();
        $response = $this->post("/admin/1");
        $response
            ->assertRedirect("/admin")
            ->assertSessionHasErrorsIn('default');
    }

    /**
     * @test
     */
    public function it_can_create_a_post()
    {
        $user = $this->login();

        $response = $this->post("/admin/", [
            'markdown_content' => 'First markdown created post',
            'html_content' => 'First created post',
        ]);

        /** @var Post $post */
        $post = Post::first();

        $response
            ->assertRedirect("/admin/{$post->id}")
            ->assertSessionHas('success');

        $this->assertThat($post->user->id, $this->identicalTo($user->id));
        $this->assertThat($post->markdown_content, $this->identicalTo('First markdown created post'));
        $this->assertThat($post->html_content, $this->identicalTo('First created post'));
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
