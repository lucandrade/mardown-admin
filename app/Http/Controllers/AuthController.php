<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class AuthController extends Controller
{
    public function login(Request $request): Response
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return redirect('/login')->withErrors(['Invalid credentials']);
        }

        return redirect('/admin');
    }

    public function logout(): Response
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return redirect('/login');
    }
}
