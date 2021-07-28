<?php declare(strict_types=1);

namespace Tests\Acceptance;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

final class AuthenticationTest extends TestCase
{
    /**
     * @test
     */
    public function it_allows_access_to_home()
    {
        $response = $this->get('/');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_redirects_guest_to_login()
    {
        $response = $this->get('/admin');
        $response
            ->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function it_redirects_to_admin_after_login()
    {
        $user = User::make('username', 'password');
        $user->save();

        $response = $this->post('/login', [
            'username' => 'username',
            'password' => 'password',
        ]);
        $response
            ->assertRedirect('/admin');
    }

    /**
     * @test
     */
    public function it_blocks_access_after_logout()
    {
        $user = User::make('username', 'password');
        $user->save();

        $this->post('/login', [
            'username' => 'username',
            'password' => 'password',
        ]);
        $response = $this->get('/logout');
        $response
            ->assertRedirect('/login');
        $response = $this->get('/admin');
        $response
            ->assertRedirect('/login');
    }
}
