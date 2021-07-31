<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

final class AuthController extends Controller
{
    /** @var Guard */
    private $auth;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(Guard $auth, LoggerInterface $logger)
    {
        $this->auth = $auth;
        $this->logger = $logger;
    }

    public function login(Request $request): Response
    {
        try {
            $credentials = $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);

            if (!$this->auth->attempt($credentials)) {
                return redirect('/login')->withErrors(['Invalid credentials']);
            }
        } catch (ValidationException $e) {
            return redirect('/login')->withErrors($e->errors());
        } catch (\Throwable $e) {
            $this->logger->error("Error validating user", [
                "e" => $e->getMessage(),
                "ex" => $e,
            ]);
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
