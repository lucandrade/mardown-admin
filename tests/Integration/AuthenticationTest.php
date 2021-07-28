<?php declare(strict_types=1);

namespace Tests\Integration;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\Integration\TestCase;

final class AuthenticationTest extends TestCase
{
    /**
     * @test
     */
    public function it_authenticate_user()
    {
        $user = User::make('username', 'password');
        $user->save();
        $authentication = Auth::attempt(['username' => 'username', 'password' => 'password']);
        $this->assertTrue($authentication);
    }

    /**
     * @test
     */
    public function it_fails_to_authenticate_user()
    {
        $authentication = Auth::attempt(['username' => 'username', 'password' => 'password']);
        $this->assertFalse($authentication);
    }
}
