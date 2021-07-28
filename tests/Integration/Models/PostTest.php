<?php declare(strict_types=1);

namespace Tests\Integration\Models;

use App\Models\Post;
use App\Models\User;
use Tests\Integration\TestCase;

final class PostTest extends TestCase
{
    /**
     * @test
     * @group debug
     */
    public function it_can_creat_a_post()
    {
        $user = User::make('username', 'password');
        $user->save();

        $newPost = Post::make('Markdown content', 'Html content', $user);
        $newPost->save();
        $post = Post::first();
        $this->assertThat($post->markdown_content, $this->identicalTo('Markdown content'));
        $this->assertThat($post->html_content, $this->identicalTo('Html content'));
    }
}
