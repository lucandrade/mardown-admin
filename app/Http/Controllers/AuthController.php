<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class AuthController extends Controller
{
    public function login(Request $request): Response
    {
        $authenticated = Auth::attempt([
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ]);

        if (!$authenticated) {
            return redirect('/login')->with('error', 'Invalid credentials');
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
